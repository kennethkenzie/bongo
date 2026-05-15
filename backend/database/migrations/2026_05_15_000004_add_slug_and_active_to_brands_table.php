<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $t) {
            $t->string('slug')->unique()->nullable()->after('name');
            $t->boolean('is_active')->default(true)->after('website');
        });
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $t) {
            $t->dropColumn(['slug', 'is_active']);
        });
    }
};
