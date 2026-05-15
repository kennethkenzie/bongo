<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->q.'%'))
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->category_id))
            ->when($request->filled('status'), function ($q) use ($request) {
                if ($request->status === 'active') $q->where('is_active', true);
                if ($request->status === 'inactive') $q->where('is_active', false);
                if ($request->status === 'low_stock') $q->where('stock', '<=', 15);
            });

        $products = $query->latest()->paginate(20);
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $brands = Brand::where('is_active', true)->orderBy('name')->get();
        $product = new Product();
        return view('admin.products.form', [
            'product'         => $product,
            'brands'          => $brands,
            'categoryOptions' => $this->buildCategoryOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        $data['image'] = $this->resolveImage($request);
        $data['slug'] = Str::slug($data['title']).'-'.Str::random(6);
        Product::create($data);
        return redirect()->route('admin.products.index')->with('status', 'Product created.');
    }

    public function edit(Product $product)
    {
        $brands = Brand::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.form', [
            'product'         => $product,
            'brands'          => $brands,
            'categoryOptions' => $this->buildCategoryOptions(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request, false);
        $resolved = $this->resolveImage($request);
        if ($resolved) {
            // Delete the previous file if it was a local upload (path starts with /storage/).
            $this->deletePreviousLocal($product->image, $resolved);
            $data['image'] = $resolved;
        } else {
            // Keep existing image when nothing new was supplied.
            unset($data['image']);
        }
        $product->update($data);
        return redirect()->route('admin.products.index')->with('status', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $this->deletePreviousLocal($product->image, null);
        $product->delete();
        return redirect()->route('admin.products.index')->with('status', 'Product deleted.');
    }

    protected function validated(Request $request, bool $creating = false): array
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'category_id'    => 'nullable|exists:categories,id',
            'description'    => 'nullable|string',
            'image_file'     => ($creating ? 'required' : 'nullable').'|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount'       => 'nullable|integer|min:0|max:99',
            'stock'          => 'nullable|integer|min:0',
            'badge'          => 'nullable|string|max:40',
            'shipping'       => 'nullable|string|max:60',
            'free_shipping'  => 'boolean',
            'is_active'      => 'boolean',
            'brand'          => 'nullable|string|max:255',
            'custom_label'   => 'nullable|string|max:100',
            'smart_bar'      => 'nullable|string|max:255',
            'colors'         => 'nullable|string',
            'attributes'     => 'nullable|string',
            'size_guide'     => 'nullable|string',
            'warranty'       => 'nullable|string',
        ]);

        foreach (['colors', 'attributes'] as $field) {
            if (isset($data[$field]) && is_string($data[$field])) {
                $decoded = json_decode($data[$field], true);
                $data[$field] = is_array($decoded) ? $decoded : null;
            }
        }

        return $data;
    }

    protected function resolveImage(Request $request): ?string
    {
        if (!$request->hasFile('image_file')) return null;

        $path = $request->file('image_file')->store('products', 'public');
        return Storage::disk('public')->url($path);
    }

    /**
     * Remove a previously-uploaded file from the public disk when it has been
     * replaced (or the product is being deleted).
     */
    protected function buildCategoryOptions(): array
    {
        $roots = Category::whereNull('parent_id')
            ->with(['children.children'])
            ->orderBy('sort_order')->orderBy('name')
            ->get();

        $options = [];
        foreach ($roots as $root) {
            $options[] = ['id' => $root->id, 'name' => $root->name, 'depth' => 0];
            foreach ($root->children->sortBy(['sort_order', 'name']) as $child) {
                $options[] = ['id' => $child->id, 'name' => $child->name, 'depth' => 1];
                foreach ($child->children->sortBy(['sort_order', 'name']) as $grand) {
                    $options[] = ['id' => $grand->id, 'name' => $grand->name, 'depth' => 2];
                }
            }
        }
        return $options;
    }

    protected function deletePreviousLocal(?string $previousUrl, ?string $newUrl): void
    {
        if (!$previousUrl || $previousUrl === $newUrl) return;
        $needle = '/storage/';
        $pos = strpos($previousUrl, $needle);
        if ($pos === false) return; // remote URL, nothing to delete
        $path = substr($previousUrl, $pos + strlen($needle));
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
