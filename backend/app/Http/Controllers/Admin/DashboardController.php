<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $todayRevenue = Order::whereDate('created_at', today())->sum('total');
        $monthRevenue = Order::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();
        $lowStockCount = Product::where('stock', '<=', 15)->count();

        $statusCounts = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $categoryMix = Category::withCount('products')
            ->orderByDesc('products_count')
            ->limit(6)
            ->get();

        return view('admin.dashboard', [
            'productCount'  => Product::count(),
            'activeProducts'=> Product::where('is_active', true)->count(),
            'categoryCount' => Category::count(),
            'orderCount'    => Order::count(),
            'userCount'     => User::count(),
            'adminCount'    => User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_MANAGER, User::ROLE_SUPPORT])->count(),
            'todayRevenue'  => $todayRevenue,
            'monthRevenue'  => $monthRevenue,
            'pendingOrders' => $pendingOrders,
            'lowStockCount' => $lowStockCount,
            'statusCounts'  => $statusCounts,
            'categoryMix'   => $categoryMix,
            'recentOrders'  => Order::with('user')->latest()->limit(8)->get(),
            'topProducts'   => Product::orderByDesc('sold')->limit(8)->get(),
            'lowStockProducts' => Product::with('category')->where('stock', '<=', 15)->orderBy('stock')->limit(8)->get(),
        ]);
    }
}
