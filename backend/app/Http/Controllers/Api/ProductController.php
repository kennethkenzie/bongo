<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $r)
    {
        $q = Product::query()->where('is_active', true);
        if ($r->filled('category')) {
            $q->whereHas('category', fn($x) => $x->where('slug', $r->category));
        }
        if ($r->filled('min_price')) $q->where('price', '>=', $r->min_price);
        if ($r->filled('max_price')) $q->where('price', '<=', $r->max_price);

        $sort = $r->input('sort', 'best_match');
        match ($sort) {
            'price_asc'  => $q->orderBy('price'),
            'price_desc' => $q->orderByDesc('price'),
            'newest'     => $q->orderByDesc('created_at'),
            'orders'     => $q->orderByDesc('sold'),
            default      => $q->latest(),
        };

        return response()->json($q->paginate(24));
    }

    public function show($id)
    {
        return response()->json(Product::with('category')->findOrFail($id));
    }

    public function flashDeals()
    {
        return response()->json(Product::where('is_active', true)->where('discount', '>=', 30)->latest()->limit(10)->get());
    }

    public function recommended()
    {
        return response()->json(Product::where('is_active', true)->latest()->limit(20)->get());
    }

    public function trending()
    {
        return response()->json(Product::where('is_active', true)->orderByDesc('sold')->limit(20)->get());
    }

    public function search(Request $r)
    {
        $q = $r->input('q');
        return response()->json(
            Product::where('is_active', true)->where('title', 'like', "%{$q}%")->latest()->paginate(24)
        );
    }
}
