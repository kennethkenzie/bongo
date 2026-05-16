<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $roots = $this->categoryTree();
        $parentOptions = $this->buildParentOptions($roots);

        return view('admin.categories.index', compact('roots', 'parentOptions'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['image'] = $this->storeImage($request) ?: null;
        $data['groups'] = $this->decodeJsonField($data['groups'] ?? null, 'groups');
        $data['featured'] = $this->decodeJsonField($data['featured'] ?? null, 'featured');
        $data['is_active'] = $request->boolean('is_active', true);

        unset($data['image_file']);

        Category::create($data);

        return back()->with('status', 'Category created.');
    }

    public function edit(Category $category)
    {
        $roots = $this->categoryTree();
        $parentOptions = $this->buildParentOptions($roots, $category);

        return view('admin.categories.edit', compact('category', 'parentOptions'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validated($request, $category);
        $data['slug'] = $this->uniqueSlug($data['name'], $category->id);
        $data['groups'] = $this->decodeJsonField($data['groups'] ?? null, 'groups');
        $data['featured'] = $this->decodeJsonField($data['featured'] ?? null, 'featured');
        $data['is_active'] = $request->boolean('is_active');

        if ($image = $this->storeImage($request)) {
            $this->deleteLocalImage($category->image);
            $data['image'] = $image;
        }

        unset($data['image_file']);

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('status', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $this->deleteTree($category);

        return back()->with('status', 'Category deleted.');
    }

    public function syncMegaMenu()
    {
        $created = 0;
        $updated = 0;

        $roots = Category::whereNull('parent_id')
            ->orderBy('sort_order')->orderBy('name')
            ->get();

        foreach ($roots as $root) {
            foreach (($root->groups ?? []) as $groupIndex => $group) {
                $groupTitle = trim((string) ($group['title'] ?? ''));
                if ($groupTitle === '') continue;

                [$groupCategory, $wasCreated] = $this->upsertMegaMenuCategory(
                    $root,
                    $groupTitle,
                    $groupIndex,
                    $root->image,
                );
                $wasCreated ? $created++ : $updated++;

                foreach (($group['links'] ?? []) as $linkIndex => $linkName) {
                    $linkName = trim((string) $linkName);
                    if ($linkName === '') continue;

                    [, $linkWasCreated] = $this->upsertMegaMenuCategory(
                        $groupCategory,
                        $linkName,
                        $linkIndex,
                        null,
                    );
                    $linkWasCreated ? $created++ : $updated++;
                }
            }
        }

        return back()->with('status', "Mega menu subcategories synced. {$created} created, {$updated} updated.");
    }

    protected function validated(Request $request, ?Category $category = null): array
    {
        $blockedParentIds = $category ? array_merge([$category->id], $this->descendantIds($category)) : [];

        return $request->validate([
            'name'       => 'required|string|max:120',
            'parent_id'  => [
                'nullable',
                'exists:categories,id',
                Rule::notIn($blockedParentIds),
            ],
            'sort_order' => 'nullable|integer|min:0|max:999999',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'groups'     => 'nullable|string',
            'featured'   => 'nullable|string',
            'is_active'  => 'nullable|boolean',
        ]);
    }

    protected function categoryTree()
    {
        return Category::whereNull('parent_id')
            ->withCount('products')
            ->with([
                'children' => fn ($q) => $q->withCount('products')->with([
                    'children' => fn ($q) => $q->withCount('products'),
                ]),
            ])
            ->orderBy('sort_order')->orderBy('name')
            ->get();
    }

    protected function buildParentOptions($roots, ?Category $exclude = null): array
    {
        $blocked = $exclude ? array_merge([$exclude->id], $this->descendantIds($exclude)) : [];
        $options = [];

        foreach ($roots as $root) {
            if (!in_array($root->id, $blocked, true)) {
                $options[] = ['id' => $root->id, 'name' => $root->name, 'depth' => 0];
            }

            foreach ($root->children as $child) {
                if (!in_array($child->id, $blocked, true)) {
                    $options[] = ['id' => $child->id, 'name' => $child->name, 'depth' => 1];
                }
            }
        }

        return $options;
    }

    protected function descendantIds(Category $category): array
    {
        $category->loadMissing('children.children');
        $ids = [];

        foreach ($category->children as $child) {
            $ids[] = $child->id;
            foreach ($child->children as $grandchild) {
                $ids[] = $grandchild->id;
            }
        }

        return $ids;
    }

    protected function upsertMegaMenuCategory(Category $parent, string $name, int $sortOrder, ?string $image): array
    {
        $slug = $this->uniqueSlug($parent->slug.' '.$name);
        $existing = Category::where('parent_id', $parent->id)->where('name', $name)->first();

        if ($existing) {
            $existing->update([
                'sort_order' => $sortOrder,
                'is_active' => true,
            ]);
            return [$existing, false];
        }

        return [Category::create([
            'name' => $name,
            'slug' => $slug,
            'image' => $image,
            'parent_id' => $parent->id,
            'sort_order' => $sortOrder,
            'is_active' => true,
        ]), true];
    }

    protected function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'category';
        $slug = $base;
        $i = 2;

        while (Category::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    protected function storeImage(Request $request): ?string
    {
        if (!$request->hasFile('image_file')) return null;

        $path = $request->file('image_file')->store('categories', 'public');
        return Storage::disk('public')->url($path);
    }

    protected function deleteLocalImage(?string $image): void
    {
        if (!$image) return;
        $needle = '/storage/';
        $pos = strpos($image, $needle);
        if ($pos === false) return;

        $path = substr($image, $pos + strlen($needle));
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    protected function deleteTree(Category $category): void
    {
        $category->loadMissing('children.children');

        foreach ($category->children as $child) {
            $this->deleteTree($child);
        }

        $this->deleteLocalImage($category->image);
        $category->delete();
    }

    protected function decodeJsonField(?string $value, string $field): ?array
    {
        if ($value === null || trim($value) === '') return null;

        $decoded = json_decode($value, true);
        abort_if(json_last_error() !== JSON_ERROR_NONE || !is_array($decoded), 422, ucfirst($field).' must be valid JSON.');

        return $decoded;
    }
}
