<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class CatalogPageController extends Controller
{
    public static function pages(): array
    {
        return [
            'in-house-products' => ['In House Products', 'Products owned and fulfilled directly by Estate Bongo Online.'],
            'digital-products' => ['Add New Digital Product', 'Create downloadable products, licenses, vouchers, and digital goods.'],
            'seller-products' => ['Seller Product', 'Review and moderate products submitted by marketplace sellers.'],
            'bulk-import' => ['Bulk Import', 'Upload product CSV/XLS files for fast catalog creation.'],
            'bulk-export' => ['Bulk Export', 'Export catalog data for reporting, backups, or supplier updates.'],
            'brands' => ['Brand', 'Manage product brands and brand storefront metadata.'],
            'custom-labels' => ['Custom Label', 'Create labels such as Choice, Bestseller, New Arrival, and Sale.'],
            'attributes' => ['Attribute', 'Manage reusable product attributes like material, storage, model, or fit.'],
            'colors' => ['Colors', 'Manage product color swatches and naming.'],
            'size-guides' => ['Size Guide', 'Create size charts for fashion, shoes, and apparel categories.'],
            'warranties' => ['Warranty', 'Define warranty policies and product-level warranty options.'],
            'smart-bars' => ['Smart Bar', 'Configure product-page promo bars, urgency banners, and announcement strips.'],
            'reviews' => ['Product Reviews', 'Moderate customer product reviews and ratings.'],
        ];
    }

    public function show(string $page)
    {
        $pages = self::pages();
        abort_unless(isset($pages[$page]), 404);

        return view('admin.catalog.page', [
            'slug' => $page,
            'page' => $pages[$page],
            'pages' => $pages,
            'productCount' => Product::count(),
            'categoryCount' => Category::count(),
        ]);
    }
}
