<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * TASK-17: Seed fictional product/stock data
 * Owner: Nigel
 * DoD: Seeder inserts 10+ product variants across multiple SKUs, sizes,
 * and stock levels, including at least one out-of-stock item per SKU,
 * verified via `php artisan db:seed`.
 */
class ProductStockSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // SKU1001 — Northstar Classic Tee, multiple sizes
            ['sku' => 'SKU1001', 'product_name' => 'Northstar Classic Tee', 'size' => 'S', 'color' => 'Black', 'stock_quantity' => 12, 'restock_date' => null],
            ['sku' => 'SKU1001', 'product_name' => 'Northstar Classic Tee', 'size' => 'M', 'color' => 'Black', 'stock_quantity' => 0,  'restock_date' => now()->addDays(7)],
            ['sku' => 'SKU1001', 'product_name' => 'Northstar Classic Tee', 'size' => 'L', 'color' => 'Black', 'stock_quantity' => 5,  'restock_date' => null],
            ['sku' => 'SKU1001', 'product_name' => 'Northstar Classic Tee', 'size' => 'XL', 'color' => 'Black', 'stock_quantity' => 0, 'restock_date' => now()->addDays(14)],

            // SKU1002 — Northstar Running Shoes
            ['sku' => 'SKU1002', 'product_name' => 'Northstar Running Shoes', 'size' => '40', 'color' => 'White', 'stock_quantity' => 8, 'restock_date' => null],
            ['sku' => 'SKU1002', 'product_name' => 'Northstar Running Shoes', 'size' => '42', 'color' => 'White', 'stock_quantity' => 0, 'restock_date' => now()->addDays(5)],
            ['sku' => 'SKU1002', 'product_name' => 'Northstar Running Shoes', 'size' => '44', 'color' => 'White', 'stock_quantity' => 3, 'restock_date' => null],

            // SKU1003 — Northstar Backpack (no size variants)
            ['sku' => 'SKU1003', 'product_name' => 'Northstar Backpack', 'size' => null, 'color' => 'Grey', 'stock_quantity' => 20, 'restock_date' => null],

            // SKU1004 — Northstar Water Bottle, fully out of stock
            ['sku' => 'SKU1004', 'product_name' => 'Northstar Water Bottle', 'size' => null, 'color' => 'Blue', 'stock_quantity' => 0, 'restock_date' => now()->addDays(3)],

            // SKU1005 — Northstar Cap, in stock
            ['sku' => 'SKU1005', 'product_name' => 'Northstar Cap', 'size' => 'One Size', 'color' => 'Navy', 'stock_quantity' => 15, 'restock_date' => null],

            // SKU1006 — discontinued item, no restock date planned
            ['sku' => 'SKU1006', 'product_name' => 'Northstar Winter Scarf', 'size' => 'One Size', 'color' => 'Red', 'stock_quantity' => 0, 'restock_date' => null],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
