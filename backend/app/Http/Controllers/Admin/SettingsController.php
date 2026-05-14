<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public static function sections(): array
    {
        return [
            'business' => [
                'label' => 'Business Settings',
                'description' => 'Store identity, address, contact, storefront and legal business profile.',
                'fields' => [
                    ['Business name', config('app.name', 'Estate Bongo Online')],
                    ['Business email', env('MAIL_FROM_ADDRESS', 'hello@estatebongo.com')],
                    ['Storefront URL', env('FRONTEND_URL', 'http://localhost:3000')],
                    ['Support phone', '+255 000 000 000'],
                ],
            ],
            'features' => [
                'label' => 'Features activation',
                'description' => 'Turn marketplace modules on/off as your platform grows.',
                'fields' => [
                    ['Multi-vendor marketplace', 'Enabled'],
                    ['Flash deals', 'Enabled'],
                    ['Wishlist', 'Enabled'],
                    ['Customer reviews', 'Enabled'],
                ],
            ],
            'languages' => [
                'label' => 'Languages',
                'description' => 'Configure storefront and admin languages.',
                'fields' => [
                    ['Default language', 'English'],
                    ['Supported languages', 'English, Swahili'],
                    ['RTL support', 'Disabled'],
                ],
            ],
            'currency' => [
                'label' => 'Currency',
                'description' => 'Add, delete, and manage marketplace currencies.',
                'fields' => [
                    ['Default currency', 'Managed below'],
                    ['Exchange rates', 'Relative to default currency'],
                    ['Price precision', '2 decimals'],
                ],
            ],
            'tax' => [
                'label' => 'Vat & TAX',
                'description' => 'Tax registration, VAT rules, invoices, and tax-inclusive pricing.',
                'fields' => [
                    ['VAT enabled', 'Disabled'],
                    ['VAT rate', '18%'],
                    ['Prices include tax', 'No'],
                ],
            ],
            'pickup' => [
                'label' => 'Pickup point',
                'description' => 'Pickup locations, opening hours, and customer collection settings.',
                'fields' => [
                    ['Pickup enabled', 'Disabled'],
                    ['Default pickup point', 'Main warehouse'],
                    ['Customer pickup code', 'Enabled'],
                ],
            ],
            'smtp' => [
                'label' => 'SMTP Settings',
                'description' => 'Outgoing email server settings for order and account notifications.',
                'fields' => [
                    ['Mailer', env('MAIL_MAILER', 'log')],
                    ['SMTP host', env('MAIL_HOST', '127.0.0.1')],
                    ['From address', env('MAIL_FROM_ADDRESS', 'hello@example.com')],
                ],
            ],
            'filesystem-cache' => [
                'label' => 'File System & Cache Configuration',
                'description' => 'Storage disks, uploaded assets, cache driver, sessions, and queue cache.',
                'fields' => [
                    ['Default filesystem', env('FILESYSTEM_DISK', 'local')],
                    ['Product uploads', 'public/products'],
                    ['Cache driver', env('CACHE_STORE', 'database')],
                    ['Session driver', env('SESSION_DRIVER', 'database')],
                ],
            ],
            'social-logins' => [
                'label' => 'Social media Logins',
                'description' => 'Global social login controls and OAuth callback configuration.',
                'fields' => [
                    ['Social login enabled', 'Disabled'],
                    ['Callback base URL', url('/auth/callback')],
                    ['Auto-create accounts', 'Enabled'],
                ],
            ],
            'facebook' => [
                'label' => 'Facebook',
                'description' => 'Facebook login, pixel, catalog sync, and Meta commerce settings.',
                'fields' => [
                    ['Facebook login', 'Disabled'],
                    ['App ID', 'Not configured'],
                    ['Pixel ID', 'Not configured'],
                ],
            ],
            'google' => [
                'label' => 'Google',
                'description' => 'Google login, analytics, tags, and Merchant Center integrations.',
                'fields' => [
                    ['Google login', 'Disabled'],
                    ['Google Analytics', 'Not configured'],
                    ['Merchant Center feed', 'Disabled'],
                ],
            ],
            'shipping' => [
                'label' => 'Shipping',
                'description' => 'Delivery methods, rates, zones, carrier partners, and free shipping rules.',
                'fields' => [
                    ['Free shipping threshold', '$50.00'],
                    ['Default shipping label', 'Free shipping'],
                    ['Express delivery', 'Enabled'],
                    ['International shipping', 'Disabled'],
                ],
            ],
        ];
    }

    public function index()
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        return view('admin.settings.index', [
            'sections' => self::sections(),
            'settings' => [
                ['Store name', config('app.name', 'Estate Bongo Online'), 'Public name shown across admin/API responses.'],
                ['Storefront URL', env('FRONTEND_URL', 'http://localhost:3000'), 'External customer-facing Next.js storefront.'],
                ['API docs URL', url('/api/v1/home'), 'Primary API payload used by the storefront home page.'],
                ['Admin access', 'Admin, Manager, Support', 'Roles that can enter the dashboard.'],
                ['Currency', 'Managed in Currency settings', 'Default and extra currencies are stored in the database.'],
                ['Image uploads', 'public/products', 'Uploaded product images are stored on the public disk.'],
            ],
        ]);
    }

    public function show(string $section)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $sections = self::sections();
        abort_unless(isset($sections[$section]), 404);

        return view('admin.settings.section', [
            'slug' => $section,
            'section' => $sections[$section],
            'sections' => $sections,
            'currencies' => $section === 'currency' ? Currency::orderByDesc('is_default')->orderBy('code')->get() : collect(),
        ]);
    }

    public function storeCurrency(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $data = $request->validate([
            'code' => ['required', 'string', 'size:3', Rule::unique('currencies', 'code')],
            'name' => ['required', 'string', 'max:120'],
            'symbol' => ['nullable', 'string', 'max:12'],
            'exchange_rate' => ['required', 'numeric', 'min:0.000001'],
            'is_default' => ['boolean'],
            'is_active' => ['boolean'],
        ]);

        $data['code'] = strtoupper($data['code']);
        $data['is_default'] = (bool) ($data['is_default'] ?? false);
        $data['is_active'] = (bool) ($data['is_active'] ?? true);

        if ($data['is_default']) {
            Currency::query()->update(['is_default' => false]);
        }

        Currency::create($data);

        return redirect()->route('admin.settings.show', 'currency')->with('status', 'Currency added.');
    }

    public function destroyCurrency(Currency $currency)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $wasDefault = $currency->is_default;
        $currency->delete();

        if ($wasDefault && Currency::exists()) {
            Currency::orderBy('code')->first()?->update(['is_default' => true]);
        }

        return redirect()->route('admin.settings.show', 'currency')->with('status', 'Currency deleted.');
    }
}
