<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

/**
 * TASK-04: Order lookup business logic
 * Owner: Nigel
 * DoD: OrderLookupService returns order status for a valid order number
 * and null for unknown ones.
 */
class OrderLookupService
{
    public function findByOrderNumber(string $orderNumber): ?Order
    {
        try {
            return Order::where('order_number', $orderNumber)->first();
        } catch (\Throwable $e) {
            Log::error('OrderLookupService DB error', ['message' => $e->getMessage()]);
            throw $e;
        }
    }
}
