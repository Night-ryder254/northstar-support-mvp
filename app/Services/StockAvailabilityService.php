<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Log;

/**
 * TASK-18: Stock availability business logic
 * Owner: Nigel
 * DoD: Service returns all size/color variants and stock levels for a
 * given SKU, or null when SKU doesn't exist.
 */
class StockAvailabilityService
{
    public function findBySku(string $sku): ?array
    {
        try {
            $variants = Product::where('sku', $sku)->get();

            if ($variants->isEmpty()) {
                return null;
            }

            return [
                'sku' => $sku,
                'product_name' => $variants->first()->product_name,
                'variants' => $variants->map(function ($product) {
                    return [
                        'size' => $product->size,
                        'color' => $product->color,
                        'in_stock' => $product->inStock(),
                        'stock_quantity' => $product->stock_quantity,
                        'restock_date' => optional($product->restock_date)->toDateString(),
                    ];
                })->values()->all(),
            ];
        } catch (\Throwable $e) {
            Log::error('StockAvailabilityService DB error', ['message' => $e->getMessage()]);
            throw $e;
        }
    }
}
