<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $r)
    {
        return response()->json(
            CartItem::with('product')->where('user_id', $r->user()->id)->get()
        );
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'variant'    => 'nullable|array',
        ]);
        $item = CartItem::updateOrCreate(
            ['user_id' => $r->user()->id, 'product_id' => $data['product_id']],
            ['quantity' => $data['quantity'], 'variant' => $data['variant'] ?? null]
        );
        return response()->json($item->load('product'), 201);
    }

    public function update(Request $r, $id)
    {
        $item = CartItem::where('user_id', $r->user()->id)->findOrFail($id);
        $item->update($r->validate(['quantity' => 'required|integer|min:1']));
        return response()->json($item);
    }

    public function destroy(Request $r, $id)
    {
        CartItem::where('user_id', $r->user()->id)->where('id', $id)->delete();
        return response()->json(['ok' => true]);
    }
}
