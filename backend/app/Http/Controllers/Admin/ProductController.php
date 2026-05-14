<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = Product::with('category');
        if ($request->filled('q')) {
            $q->where('title', 'like', '%'.$request->q.'%');
        }
        $products = $q->latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $product = new Product();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['image'] = $this->resolveImage($request, $data['image'] ?? null);
        abort_unless($data['image'], 422, 'An image file or URL is required.');
        $data['slug'] = Str::slug($data['title']).'-'.Str::random(6);
        Product::create($data);
        return redirect()->route('admin.products.index')->with('status', 'Product created.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request);
        $resolved = $this->resolveImage($request, $data['image'] ?? null);
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

    protected function validated(Request $request): array
    {
        return $request->validate([
            'title'          => 'required|string|max:255',
            'category_id'    => 'nullable|exists:categories,id',
            'description'    => 'nullable|string',
            'image'          => 'nullable|string|max:2048',
            'image_file'     => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount'       => 'nullable|integer|min:0|max:99',
            'stock'          => 'nullable|integer|min:0',
            'badge'          => 'nullable|string|max:40',
            'shipping'       => 'nullable|string|max:60',
            'free_shipping'  => 'boolean',
            'is_active'      => 'boolean',
        ]);
    }

    /**
     * Returns the final image URL to persist:
     *  - if a file was uploaded, store it on the public disk and return its public URL
     *  - else if a URL was provided, return that
     *  - else null (caller decides what to do)
     */
    protected function resolveImage(Request $request, ?string $url): ?string
    {
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            return Storage::disk('public')->url($path);
        }
        return $url ?: null;
    }

    /**
     * Remove a previously-uploaded file from the public disk when it has been
     * replaced (or the product is being deleted).
     */
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
