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
        return response()->json([
            'categories'   => Category::where('is_active', true)->orderBy('sort_order')->limit(14)->get(),
            'flash_deals'  => Product::where('is_active', true)->where('discount', '>=', 30)->limit(10)->get(),
            'recommended'  => Product::where('is_active', true)->inRandomOrder()->limit(12)->get(),
            'trending'     => Product::where('is_active', true)->orderBy('sold', 'desc')->limit(10)->get(),
            'more_to_love' => Product::where('is_active', true)->inRandomOrder()->limit(24)->get(),
        ]);
    }
}
