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
use App\Http\Controllers\Admin\CatalogCrudController as AdminCatalogCrudController;

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
    Route::post('/catalog/brands', [AdminCatalogCrudController::class, 'storeBrand'])->name('catalog.brands.store');
    Route::delete('/catalog/brands/{brand}', [AdminCatalogCrudController::class, 'destroyBrand'])->name('catalog.brands.destroy');

    Route::get('/catalog/custom-labels', [AdminCatalogPageController::class, 'customLabels'])->name('catalog.labels');
    Route::post('/catalog/custom-labels', [AdminCatalogCrudController::class, 'storeLabel'])->name('catalog.labels.store');
    Route::delete('/catalog/custom-labels/{customLabel}', [AdminCatalogCrudController::class, 'destroyLabel'])->name('catalog.labels.destroy');

    Route::get('/catalog/attributes', [AdminCatalogPageController::class, 'attributes'])->name('catalog.attributes');
    Route::post('/catalog/attributes', [AdminCatalogCrudController::class, 'storeAttribute'])->name('catalog.attributes.store');
    Route::delete('/catalog/attributes/{productAttribute}', [AdminCatalogCrudController::class, 'destroyAttribute'])->name('catalog.attributes.destroy');

    Route::get('/catalog/colors', [AdminCatalogPageController::class, 'colors'])->name('catalog.colors');
    Route::post('/catalog/colors', [AdminCatalogCrudController::class, 'storeColor'])->name('catalog.colors.store');
    Route::delete('/catalog/colors/{productColor}', [AdminCatalogCrudController::class, 'destroyColor'])->name('catalog.colors.destroy');

    Route::get('/catalog/size-guides', [AdminCatalogPageController::class, 'sizeGuides'])->name('catalog.size_guides');
    Route::post('/catalog/size-guides', [AdminCatalogCrudController::class, 'storeSizeGuide'])->name('catalog.size_guides.store');
    Route::delete('/catalog/size-guides/{sizeGuide}', [AdminCatalogCrudController::class, 'destroySizeGuide'])->name('catalog.size_guides.destroy');

    Route::get('/catalog/warranties', [AdminCatalogPageController::class, 'warranties'])->name('catalog.warranties');
    Route::post('/catalog/warranties', [AdminCatalogCrudController::class, 'storeWarranty'])->name('catalog.warranties.store');
    Route::delete('/catalog/warranties/{warranty}', [AdminCatalogCrudController::class, 'destroyWarranty'])->name('catalog.warranties.destroy');

    Route::get('/catalog/smart-bars', [AdminCatalogPageController::class, 'smartBars'])->name('catalog.smart_bars');
    Route::post('/catalog/smart-bars', [AdminCatalogCrudController::class, 'storeSmartBar'])->name('catalog.smart_bars.store');
    Route::delete('/catalog/smart-bars/{smartBar}', [AdminCatalogCrudController::class, 'destroySmartBar'])->name('catalog.smart_bars.destroy');
    Route::get('/catalog/reviews', [AdminCatalogPageController::class, 'reviews'])->name('catalog.reviews');
    Route::get('/catalog/{page}', [AdminCatalogPageController::class, 'show'])->name('catalog.show');

    Route::resource('products', AdminProductController::class)
        ->except(['show']);

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::post('/categories/sync-mega-menu', [AdminCategoryController::class, 'syncMegaMenu'])->name('categories.sync_mega_menu');
    Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
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
