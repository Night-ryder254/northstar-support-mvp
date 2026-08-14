<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StockAvailabilityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * TASK-19: Stock availability API endpoint
 * Owner: Nigel
 * DoD: GET /api/stock/{sku} returns 200 with variant list for valid SKU,
 * 404 for unknown SKU, 422 for malformed input.
 */
class StockController extends Controller
{
    public function __construct(private StockAvailabilityService $stock)
    {
    }

    public function show(string $sku): JsonResponse
    {
        $validator = Validator::make(
            ['sku' => $sku],
            ['sku' => ['required', 'string', 'regex:/^SKU\d{4,}$/']]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid SKU format. Expected format: SKU1001.',
            ], 422);
        }

        try {
            $result = $this->stock->findBySku($sku);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => 'A system error occurred. Please try again shortly.',
            ], 500);
        }

        if (! $result) {
            return response()->json([
                'success' => false,
                'error' => 'No product found with that SKU.',
            ], 404);
        }

        return response()->json(['success' => true, 'data' => $result]);
    }
}
