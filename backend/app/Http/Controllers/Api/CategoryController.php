<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(
            Category::where('is_active', true)->orderBy('sort_order')->get()
        );
    }

    public function show($slug)
    {
        $cat = Category::where('slug', $slug)->firstOrFail();
        return response()->json([
            'category' => $cat,
            'products' => $cat->products()->paginate(24),
        ]);
    }
}
