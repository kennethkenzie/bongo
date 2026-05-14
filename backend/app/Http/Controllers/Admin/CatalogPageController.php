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
            'in-house-products' => ['In House Products', 'Products owned and fulfilled directly by Estate Bongo Online.', 'admin.catalog.in_house'],
            'digital-products' => ['Add New Digital Product', 'Create downloadable products, licenses, vouchers, and digital goods.', 'admin.catalog.digital'],
            'seller-products' => ['Seller Product', 'Review and moderate products submitted by marketplace sellers.', 'admin.catalog.seller'],
            'bulk-import' => ['Bulk Import', 'Upload product CSV/XLS files for fast catalog creation.', 'admin.catalog.import'],
            'bulk-export' => ['Bulk Export', 'Export catalog data for reporting, backups, or supplier updates.', 'admin.catalog.export'],
            'brands' => ['Brand', 'Manage product brands and brand storefront metadata.', 'admin.catalog.brands'],
            'custom-labels' => ['Custom Label', 'Create labels such as Choice, Bestseller, New Arrival, and Sale.', 'admin.catalog.labels'],
            'attributes' => ['Attribute', 'Manage reusable product attributes like material, storage, model, or fit.', 'admin.catalog.attributes'],
            'colors' => ['Colors', 'Manage product color swatches and naming.', 'admin.catalog.colors'],
            'size-guides' => ['Size Guide', 'Create size charts for fashion, shoes, and apparel categories.', 'admin.catalog.size_guides'],
            'warranties' => ['Warranty', 'Define warranty policies and product-level warranty options.', 'admin.catalog.warranties'],
            'smart-bars' => ['Smart Bar', 'Configure product-page promo bars, urgency banners, and announcement strips.', 'admin.catalog.smart_bars'],
            'reviews' => ['Product Reviews', 'Moderate customer product reviews and ratings.', 'admin.catalog.reviews'],
        ];
    }

    public function inHouseProducts() { return $this->render('in-house-products'); }
    public function digitalProducts() { return $this->render('digital-products'); }
    public function sellerProducts() { return $this->render('seller-products'); }
    public function bulkImport() { return $this->render('bulk-import'); }
    public function bulkExport() { return $this->render('bulk-export'); }
    public function brands() { return $this->render('brands'); }
    public function customLabels() { return $this->render('custom-labels'); }
    public function attributes() { return $this->render('attributes'); }
    public function colors() { return $this->render('colors'); }
    public function sizeGuides() { return $this->render('size-guides'); }
    public function warranties() { return $this->render('warranties'); }
    public function smartBars() { return $this->render('smart-bars'); }
    public function reviews() { return $this->render('reviews'); }

    public function show(string $page)
    {
        return $this->render($page);
    }

    protected function render(string $page)
    {
        $pages = self::pages();
        abort_unless(isset($pages[$page]), 404);

        $products = Product::with('category')
            ->when($page === 'in-house-products', fn ($q) => $q->where('is_active', true))
            ->latest()
            ->limit(8)
            ->get();

        return view('admin.catalog.page', [
            'slug' => $page,
            'page' => $pages[$page],
            'pages' => $pages,
            'products' => $products,
            'productCount' => Product::count(),
            'activeProductCount' => Product::where('is_active', true)->count(),
            'categoryCount' => Category::count(),
        ]);
    }
}
