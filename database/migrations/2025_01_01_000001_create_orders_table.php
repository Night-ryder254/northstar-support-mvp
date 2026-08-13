<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * TASK-01: Create orders table
     * Owner: Nigel
     * DoD: Migration creates `orders` table with all required columns and runs without error.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 20)->unique();
            $table->string('customer_name', 120);
            $table->enum('status', [
                'processing',
                'packed',
                'shipped',
                'delivered',
                'cancelled',
            ])->default('processing');
            $table->date('estimated_delivery')->nullable();
            $table->timestamps();

            $table->index('order_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
