<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->with('children.children')
            ->orderBy('sort_order')
            ->limit(14)
            ->get()
            ->map(fn (Category $category) => $category->storefrontPayload())
            ->values();

        return response()->json([
            'categories'   => $categories,
            'flash_deals'  => Product::where('is_active', true)->where('discount', '>=', 30)->latest()->limit(10)->get(),
            'recommended'  => Product::where('is_active', true)->latest()->limit(12)->get(),
            'trending'     => Product::where('is_active', true)->orderBy('sold', 'desc')->limit(10)->get(),
            'more_to_love' => Product::where('is_active', true)->latest()->limit(24)->get(),
        ]);
    }
}
