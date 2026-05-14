<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
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
        $product->update($this->validated($request));
        return redirect()->route('admin.products.index')->with('status', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('status', 'Product deleted.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'title'          => 'required|string|max:255',
            'category_id'    => 'nullable|exists:categories,id',
            'description'    => 'nullable|string',
            'image'          => 'required|url',
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
}
