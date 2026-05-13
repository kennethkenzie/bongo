<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WishlistItem;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $r)
    {
        return response()->json(
            WishlistItem::with('product')->where('user_id', $r->user()->id)->get()
        );
    }

    public function store(Request $r)
    {
        $data = $r->validate(['product_id' => 'required|exists:products,id']);
        $item = WishlistItem::firstOrCreate(['user_id' => $r->user()->id, 'product_id' => $data['product_id']]);
        return response()->json($item, 201);
    }

    public function destroy(Request $r, $productId)
    {
        WishlistItem::where('user_id', $r->user()->id)->where('product_id', $productId)->delete();
        return response()->json(['ok' => true]);
    }
}
