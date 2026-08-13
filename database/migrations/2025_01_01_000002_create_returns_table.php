<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * TASK-02: Create returns table
     * Owner: Nigel
     * DoD: Migration creates `returns` table referencing order_number and runs without error.
     */
    public function up(): void
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 20);
            $table->enum('return_status', [
                'not_requested',
                'requested',
                'in_transit',
                'received',
                'rejected',
            ])->default('not_requested');
            $table->enum('refund_status', [
                'not_applicable',
                'pending',
                'processed',
            ])->default('not_applicable');
            $table->string('return_reason', 255)->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->index('order_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
