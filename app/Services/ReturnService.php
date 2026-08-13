<?php

namespace App\Services;

use App\Models\Order;
use App\Models\ReturnRequest;
use Illuminate\Support\Facades\Log;

/**
 * TASK-05: Return/refund lookup business logic
 * Owner: Nigel
 * DoD: ReturnService returns return+refund status for a valid order
 * number, or a "not requested" default when no return row exists.
 */
class ReturnService
{
    public function findByOrderNumber(string $orderNumber): ?array
    {
        try {
            $order = Order::where('order_number', $orderNumber)->first();

            if (! $order) {
                return null;
            }

            $return = ReturnRequest::where('order_number', $orderNumber)->first();

            if (! $return) {
                return [
                    'order_number' => $orderNumber,
                    'return_status' => 'not_requested',
                    'refund_status' => 'not_applicable',
                    'return_reason' => null,
                ];
            }

            return [
                'order_number' => $return->order_number,
                'return_status' => $return->return_status,
                'refund_status' => $return->refund_status,
                'return_reason' => $return->return_reason,
            ];
        } catch (\Throwable $e) {
            Log::error('ReturnService DB error', ['message' => $e->getMessage()]);
            throw $e;
        }
    }

    public function returnInstructions(): array
    {
        return [
            'steps' => [
                'Log into your account and open "My Orders".',
                'Select the order and click "Request Return".',
                'Print the prepaid return label and attach it to the package.',
                'Drop the package at any partner courier point within 7 days.',
                'Refunds are processed within 5–7 business days of receipt.',
            ],
        ];
    }
}
