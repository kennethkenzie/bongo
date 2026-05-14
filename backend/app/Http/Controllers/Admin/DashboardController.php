<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'productCount'  => Product::count(),
            'categoryCount' => Category::count(),
            'orderCount'    => Order::count(),
            'userCount'     => User::count(),
            'recentOrders'  => Order::with('user')->latest()->limit(8)->get(),
            'topProducts'   => Product::orderByDesc('sold')->limit(8)->get(),
        ]);
    }
}
