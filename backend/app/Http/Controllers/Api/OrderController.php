<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $r)
    {
        return response()->json(
            Order::with('items')->where('user_id', $r->user()->id)->latest()->paginate(20)
        );
    }

    public function show(Request $r, $id)
    {
        return response()->json(
            Order::with('items.product')->where('user_id', $r->user()->id)->findOrFail($id)
        );
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'shipping_address' => 'required|array',
            'payment_method'   => 'required|string',
        ]);

        return DB::transaction(function () use ($r, $data) {
            $cart = CartItem::with('product')->where('user_id', $r->user()->id)->get();
            abort_if($cart->isEmpty(), 422, 'Cart is empty');

            $subtotal = $cart->sum(fn ($i) => $i->product->price * $i->quantity);
            $shipping = $subtotal >= 50 ? 0 : 4.99;
            $total = $subtotal + $shipping;

            $order = Order::create([
                'user_id'          => $r->user()->id,
                'order_number'     => 'EBO-' . strtoupper(Str::random(10)),
                'status'           => 'pending',
                'subtotal'         => $subtotal,
                'shipping'         => $shipping,
                'discount'         => 0,
                'total'            => $total,
                'shipping_address' => $data['shipping_address'],
                'payment_method'   => $data['payment_method'],
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'title'      => $item->product->title,
                    'image'      => $item->product->image,
                    'price'      => $item->product->price,
                    'quantity'   => $item->quantity,
                    'variant'    => $item->variant,
                ]);
            }

            CartItem::where('user_id', $r->user()->id)->delete();

            return response()->json($order->load('items'), 201);
        });
    }
}
