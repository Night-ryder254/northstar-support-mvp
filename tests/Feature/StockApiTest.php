<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * TASK-21: Stock availability test suite
 * Owner: Nigel
 * DoD: Test suite covers valid SKU, unknown SKU, and malformed SKU
 * scenarios, all passing via `php artisan test`.
 */
class StockApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Product::create(['sku' => 'SKU1001', 'product_name' => 'Test Tee', 'size' => 'M', 'color' => 'Black', 'stock_quantity' => 5]);
        Product::create(['sku' => 'SKU1001', 'product_name' => 'Test Tee', 'size' => 'L', 'color' => 'Black', 'stock_quantity' => 0, 'restock_date' => now()->addDays(5)]);
    }

    /** TEST-11: Valid SKU lookup returns 200 with all variants */
    public function test_valid_sku_lookup_returns_variants(): void
    {
        $response = $this->getJson('/api/stock/SKU1001');
        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonCount(2, 'data.variants');
    }

    /** TEST-12: Unknown SKU returns 404 */
    public function test_unknown_sku_returns_404(): void
    {
        $response = $this->getJson('/api/stock/SKU9999');
        $response->assertStatus(404)->assertJson(['success' => false]);
    }

    /** TEST-13: Malformed SKU format returns 422 */
    public function test_malformed_sku_returns_422(): void
    {
        $response = $this->getJson('/api/stock/xyz!!');
        $response->assertStatus(422)->assertJson(['success' => false]);
    }

    /** TEST-14: Out-of-stock variant correctly flagged with restock date */
    public function test_out_of_stock_variant_shows_restock_info(): void
    {
        $response = $this->getJson('/api/stock/SKU1001');
        $variants = collect($response->json('data.variants'));
        $outOfStock = $variants->firstWhere('size', 'L');

        $this->assertFalse($outOfStock['in_stock']);
        $this->assertNotNull($outOfStock['restock_date']);
    }
}
