<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public const STATUSES = ['pending', 'paid', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'];

    public function index(Request $request)
    {
        $orders = Order::with(['user', 'items'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%'.$request->q.'%';
                $query->where('order_number', 'like', $term)
                    ->orWhereHas('user', fn ($q) => $q->where('name', 'like', $term)->orWhere('email', 'like', $term));
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->latest()
            ->paginate(20);

        $statuses = self::STATUSES;

        return view('admin.orders.index', compact('orders', 'statuses'));
    }


    public function inhouse()
    {
        return $this->segment('Inhouse orders', 'Orders fulfilled directly by Estate Bongo Online warehouses.', 'inhouse');
    }

    public function seller()
    {
        return $this->segment('Seller Orders', 'Orders assigned to marketplace sellers for fulfillment.', 'seller');
    }

    public function pickupPoint()
    {
        return $this->segment('Pickup Point Orders', 'Orders customers will collect from pickup points.', 'pickup-point');
    }

    protected function segment(string $title, string $subtitle, string $type)
    {
        $orders = Order::with(['user', 'items'])->latest()->paginate(20);
        $statuses = self::STATUSES;

        return view('admin.orders.segment', compact('orders', 'statuses', 'title', 'subtitle', 'type'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(self::STATUSES)],
        ]);

        $order->update($data);

        return back()->with('status', 'Order status updated.');
    }
}
