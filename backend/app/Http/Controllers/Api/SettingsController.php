<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\JsonResponse;

class SettingsController extends Controller
{
    public function currency(): JsonResponse
    {
        $currency = Currency::where('is_default', true)->where('is_active', true)->first()
            ?? Currency::where('is_active', true)->orderBy('code')->first();

        return response()->json($currency ?: [
            'code' => 'USD',
            'name' => 'US Dollar',
            'symbol' => '$',
            'exchange_rate' => 1,
            'is_default' => true,
            'is_active' => true,
        ]);
    }
}
