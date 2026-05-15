<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('sort_order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:120',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ]);
        if ($request->hasFile('image_file')) {
            $data['image'] = Storage::disk('public')->url($request->file('image_file')->store('categories', 'public'));
        }
        unset($data['image_file']);
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = true;
        Category::create($data);
        return back()->with('status', 'Category created.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('status', 'Category deleted.');
    }
}
