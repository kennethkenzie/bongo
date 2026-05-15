<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('logo')->nullable();
            $t->string('website')->nullable();
            $t->timestamps();
        });

        Schema::create('custom_labels', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('color', 7)->default('#7c2ae8');
            $t->timestamps();
        });

        Schema::create('product_attributes', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->json('values')->nullable();
            $t->timestamps();
        });

        Schema::create('product_colors', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('hex', 7)->default('#000000');
            $t->timestamps();
        });

        Schema::create('size_guides', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->text('content')->nullable();
            $t->timestamps();
        });

        Schema::create('warranties', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->text('description')->nullable();
            $t->timestamps();
        });

        Schema::create('smart_bars', function (Blueprint $t) {
            $t->id();
            $t->string('message');
            $t->string('cta_text')->nullable();
            $t->string('style')->default('brand');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('smart_bars');
        Schema::dropIfExists('warranties');
        Schema::dropIfExists('size_guides');
        Schema::dropIfExists('product_colors');
        Schema::dropIfExists('product_attributes');
        Schema::dropIfExists('custom_labels');
        Schema::dropIfExists('brands');
    }
};
