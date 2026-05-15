<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $t) {
            $t->string('brand')->nullable()->after('badge');
            $t->string('custom_label')->nullable()->after('brand');
            $t->string('smart_bar')->nullable()->after('custom_label');
            $t->json('colors')->nullable()->after('smart_bar');
            $t->json('attributes')->nullable()->after('colors');
            $t->text('size_guide')->nullable()->after('attributes');
            $t->text('warranty')->nullable()->after('size_guide');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $t) {
            $t->dropColumn(['brand', 'custom_label', 'smart_bar', 'colors', 'attributes', 'size_guide', 'warranty']);
        });
    }
};
