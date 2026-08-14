<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * TASK-16: Create products table
     * Owner: Nigel
     * DoD: Migration creates `products` table with SKU, size, and stock
     * quantity, and runs without error.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 30)->index();
            $table->string('product_name', 150);
            $table->string('size', 20)->nullable();
            $table->string('color', 40)->nullable();
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->date('restock_date')->nullable();
            $table->timestamps();

            // A product can have multiple rows for the same SKU when it
            // comes in different sizes/colors — each variant is its own
            // stock-tracked row, which is why sku is indexed but not unique.
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
