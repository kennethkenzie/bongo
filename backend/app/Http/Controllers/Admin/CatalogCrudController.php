<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CustomLabel;
use App\Models\ProductAttribute;
use App\Models\ProductColor;
use App\Models\SizeGuide;
use App\Models\Warranty;
use App\Models\SmartBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CatalogCrudController extends Controller
{
    // ── Brands ─────────────────────────────────────────────────────
    public function storeBrand(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'logo_file' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'website'   => 'nullable|url|max:2048',
            'is_active' => 'boolean',
        ], [
            'logo_file.required' => 'Brand logo is required. Please upload a logo before registering the brand.',
        ]);

        $path = $request->file('logo_file')->store('brands', 'public');

        Brand::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']).'-'.Str::random(5),
            'logo' => Storage::disk('public')->url($path),
            'website' => $data['website'] ?? null,
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);

        return redirect()->route('admin.catalog.brands')->with('status', 'Brand created.');
    }

    public function destroyBrand(Brand $brand)
    {
        $this->deleteLocalAsset($brand->logo);
        $brand->delete();
        return redirect()->route('admin.catalog.brands')->with('status', 'Brand deleted.');
    }

    protected function deleteLocalAsset(?string $url): void
    {
        if (!$url) return;
        $needle = '/storage/';
        $pos = strpos($url, $needle);
        if ($pos === false) return;
        $path = substr($url, $pos + strlen($needle));
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    // ── Custom Labels ───────────────────────────────────────────────
    public function storeLabel(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:60',
            'color' => 'nullable|string|max:7',
        ]);
        CustomLabel::create($data);
        return redirect()->route('admin.catalog.labels')->with('status', 'Label created.');
    }

    public function destroyLabel(CustomLabel $customLabel)
    {
        $customLabel->delete();
        return redirect()->route('admin.catalog.labels')->with('status', 'Label deleted.');
    }

    // ── Attributes ──────────────────────────────────────────────────
    public function storeAttribute(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:100',
            'values' => 'nullable|string',
        ]);
        if (!empty($data['values'])) {
            $data['values'] = array_values(array_filter(array_map('trim', explode(',', $data['values']))));
        } else {
            $data['values'] = [];
        }
        ProductAttribute::create($data);
        return redirect()->route('admin.catalog.attributes')->with('status', 'Attribute created.');
    }

    public function destroyAttribute(ProductAttribute $productAttribute)
    {
        $productAttribute->delete();
        return redirect()->route('admin.catalog.attributes')->with('status', 'Attribute deleted.');
    }

    // ── Colors ──────────────────────────────────────────────────────
    public function storeColor(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:60',
            'hex'  => ['required', 'string', 'regex:/^#[0-9a-fA-F]{3,6}$/'],
        ]);
        ProductColor::create($data);
        return redirect()->route('admin.catalog.colors')->with('status', 'Color added.');
    }

    public function destroyColor(ProductColor $productColor)
    {
        $productColor->delete();
        return redirect()->route('admin.catalog.colors')->with('status', 'Color deleted.');
    }

    // ── Size Guides ─────────────────────────────────────────────────
    public function storeSizeGuide(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'content' => 'nullable|string',
        ]);
        SizeGuide::create($data);
        return redirect()->route('admin.catalog.size_guides')->with('status', 'Size guide created.');
    }

    public function destroySizeGuide(SizeGuide $sizeGuide)
    {
        $sizeGuide->delete();
        return redirect()->route('admin.catalog.size_guides')->with('status', 'Size guide deleted.');
    }

    // ── Warranties ──────────────────────────────────────────────────
    public function storeWarranty(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);
        Warranty::create($data);
        return redirect()->route('admin.catalog.warranties')->with('status', 'Warranty created.');
    }

    public function destroyWarranty(Warranty $warranty)
    {
        $warranty->delete();
        return redirect()->route('admin.catalog.warranties')->with('status', 'Warranty deleted.');
    }

    // ── Smart Bars ──────────────────────────────────────────────────
    public function storeSmartBar(Request $request)
    {
        $data = $request->validate([
            'message'  => 'required|string|max:255',
            'cta_text' => 'nullable|string|max:60',
            'style'    => 'nullable|in:brand,warning,info,success',
        ]);
        SmartBar::create($data);
        return redirect()->route('admin.catalog.smart_bars')->with('status', 'Smart bar created.');
    }

    public function destroySmartBar(SmartBar $smartBar)
    {
        $smartBar->delete();
        return redirect()->route('admin.catalog.smart_bars')->with('status', 'Smart bar deleted.');
    }
}
