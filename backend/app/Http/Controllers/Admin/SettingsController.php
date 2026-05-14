<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        return view('admin.settings.index', [
            'settings' => [
                ['Store name', config('app.name', 'Estate Bongo Online'), 'Public name shown across admin/API responses.'],
                ['Storefront URL', env('FRONTEND_URL', 'http://localhost:3000'), 'External customer-facing Next.js storefront.'],
                ['API docs URL', url('/api/v1/home'), 'Primary API payload used by the storefront home page.'],
                ['Admin access', 'Admin, Manager, Support', 'Roles that can enter the dashboard.'],
                ['Currency', 'USD', 'Default currency used by seeded products and order totals.'],
                ['Image uploads', 'public/products', 'Uploaded product images are stored on the public disk.'],
            ],
        ]);
    }
}
