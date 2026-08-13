<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ReturnService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * TASK-07: Return/refund API endpoint
 * Owner: Nigel
 * DoD: GET /api/returns/{order_number} and /instructions both return
 * correct JSON with proper status codes, verified by feature tests.
 */
class ReturnController extends Controller
{
    public function __construct(private ReturnService $returns)
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
            $result = $this->returns->findByOrderNumber($orderNumber);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => 'A system error occurred. Please try again shortly.',
            ], 500);
        }

        if (! $result) {
            return response()->json([
                'success' => false,
                'error' => 'No order found with that number.',
            ], 404);
        }

        return response()->json(['success' => true, 'data' => $result]);
    }

    public function instructions(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->returns->returnInstructions(),
        ]);
    }
}
