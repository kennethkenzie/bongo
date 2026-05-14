<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\CatalogPageController as AdminCatalogPageController;

// Root: send visitors to the admin console.
Route::get('/', fn () => redirect('/admin'));

// Health & version payload (kept for status checks)
Route::get('/status', fn () => response()->json([
    'name'    => config('app.name'),
    'version' => '1.0.0',
    'status'  => 'ok',
    'docs'    => url('/api/v1/home'),
    'admin'   => url('/admin'),
]));

// Admin login (guest-only)
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.attempt');
});

// Admin console (authenticated + admin role)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', AdminProductController::class)
        ->except(['show']);
    Route::get('/catalog/{page}', [AdminCatalogPageController::class, 'show'])->name('catalog.show');

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::get('/roles', [AdminUserController::class, 'roles'])->name('roles.index');
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/{section}', [AdminSettingsController::class, 'show'])->name('settings.show');
});
