<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $t) {
            $t->id();
            $t->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $t->string('title');
            $t->string('slug')->unique();
            $t->text('description')->nullable();
            $t->string('image');
            $t->json('images')->nullable();
            $t->decimal('price', 10, 2);
            $t->decimal('original_price', 10, 2)->nullable();
            $t->unsignedTinyInteger('discount')->default(0);
            $t->decimal('rating', 3, 2)->default(0);
            $t->unsignedInteger('sold')->default(0);
            $t->unsignedInteger('stock')->default(0);
            $t->string('shipping')->nullable();
            $t->boolean('free_shipping')->default(false);
            $t->string('badge')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
            $t->index(['category_id', 'is_active']);
            $t->index('sold');
            $t->index('rating');
            $t->index('discount');
        });
    }
    public function down(): void { Schema::dropIfExists('products'); }
};
