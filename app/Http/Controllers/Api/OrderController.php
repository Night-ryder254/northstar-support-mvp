<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OrderLookupService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * TASK-06: Order lookup API endpoint
 * Owner: Nigel
 * DoD: GET /api/orders/{order_number} returns 200 with order data for
 * valid numbers, 404 for unknown, 422 for malformed input.
 */
class OrderController extends Controller
{
    public function __construct(private OrderLookupService $orders)
    {
    }

    public function show(string $orderNumber): JsonResponse
    {
        $validator = Validator::make(
            ['order_number' => $orderNumber],
            ['order_number' => ['required', 'string', 'regex:/^ORD\d{4,}$/']]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid order number format. Expected format: ORD1001.',
            ], 422);
        }

        try {
            $order = $this->orders->findByOrderNumber($orderNumber);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => 'A system error occurred. Please try again shortly.',
            ], 500);
        }

        if (! $order) {
            return response()->json([
                'success' => false,
                'error' => 'No order found with that number.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'order_number' => $order->order_number,
                'status' => $order->status,
                'estimated_delivery' => optional($order->estimated_delivery)->toDateString(),
            ],
        ]);
    }
}
