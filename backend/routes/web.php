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
use App\Http\Controllers\Admin\AiStudioController as AdminAiStudioController;

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

// Laravel's default auth middleware looks for a route named `login`.
// Point it to the admin login screen because this app is admin-first.
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');

// Admin login (guest-only)
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.attempt');
});

// Admin console (authenticated + admin role)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/catalog/in-house-products', [AdminCatalogPageController::class, 'inHouseProducts'])->name('catalog.in_house');
    Route::get('/catalog/digital-products', [AdminCatalogPageController::class, 'digitalProducts'])->name('catalog.digital');
    Route::get('/catalog/seller-products', [AdminCatalogPageController::class, 'sellerProducts'])->name('catalog.seller');
    Route::get('/catalog/bulk-import', [AdminCatalogPageController::class, 'bulkImport'])->name('catalog.import');
    Route::get('/catalog/bulk-export', [AdminCatalogPageController::class, 'bulkExport'])->name('catalog.export');
    Route::get('/catalog/brands', [AdminCatalogPageController::class, 'brands'])->name('catalog.brands');
    Route::get('/catalog/custom-labels', [AdminCatalogPageController::class, 'customLabels'])->name('catalog.labels');
    Route::get('/catalog/attributes', [AdminCatalogPageController::class, 'attributes'])->name('catalog.attributes');
    Route::get('/catalog/colors', [AdminCatalogPageController::class, 'colors'])->name('catalog.colors');
    Route::get('/catalog/size-guides', [AdminCatalogPageController::class, 'sizeGuides'])->name('catalog.size_guides');
    Route::get('/catalog/warranties', [AdminCatalogPageController::class, 'warranties'])->name('catalog.warranties');
    Route::get('/catalog/smart-bars', [AdminCatalogPageController::class, 'smartBars'])->name('catalog.smart_bars');
    Route::get('/catalog/reviews', [AdminCatalogPageController::class, 'reviews'])->name('catalog.reviews');
    Route::get('/catalog/{page}', [AdminCatalogPageController::class, 'show'])->name('catalog.show');

    Route::resource('products', AdminProductController::class)
        ->except(['show']);

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/ai-studio/product', [AdminAiStudioController::class, 'product'])->name('ai.product');
    Route::get('/ai-studio/templates', [AdminAiStudioController::class, 'templates'])->name('ai.templates');
    Route::get('/ai-studio/usage', [AdminAiStudioController::class, 'usage'])->name('ai.usage');
    Route::get('/ai-studio/configuration', [AdminAiStudioController::class, 'configuration'])->name('ai.configuration');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/inhouse', [AdminOrderController::class, 'inhouse'])->name('orders.inhouse');
    Route::get('/orders/seller', [AdminOrderController::class, 'seller'])->name('orders.seller');
    Route::get('/orders/pickup-point', [AdminOrderController::class, 'pickupPoint'])->name('orders.pickup');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::get('/roles', [AdminUserController::class, 'roles'])->name('roles.index');
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/currency', [AdminSettingsController::class, 'storeCurrency'])->name('settings.currency.store');
    Route::delete('/settings/currency/{currency}', [AdminSettingsController::class, 'destroyCurrency'])->name('settings.currency.destroy');
    Route::get('/settings/{section}', [AdminSettingsController::class, 'show'])->name('settings.show');
});
