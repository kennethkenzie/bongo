<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('order_number')->unique();
            $t->string('status')->default('pending');
            $t->decimal('subtotal', 12, 2)->default(0);
            $t->decimal('shipping', 10, 2)->default(0);
            $t->decimal('discount', 10, 2)->default(0);
            $t->decimal('total', 12, 2)->default(0);
            $t->json('shipping_address')->nullable();
            $t->string('payment_method')->nullable();
            $t->timestamps();
        });

        Schema::create('order_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('order_id')->constrained()->cascadeOnDelete();
            $t->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $t->string('title');
            $t->string('image')->nullable();
            $t->decimal('price', 10, 2);
            $t->unsignedInteger('quantity');
            $t->json('variant')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
