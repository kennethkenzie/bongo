<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(
            Category::whereNull('parent_id')
                ->where('is_active', true)
                ->with('children.children')
                ->orderBy('sort_order')
                ->get()
                ->map(fn (Category $category) => $category->storefrontPayload())
                ->values()
        );
    }

    public function show($slug)
    {
        $cat = Category::where('slug', $slug)->with('children.children')->firstOrFail();
        return response()->json([
            'category' => $cat->storefrontPayload(),
            'products' => $cat->products()->where('is_active', true)->latest()->paginate(24),
        ]);
    }
}
