<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\ReturnRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * TASK-09: API test suite
 * Owner: Nigel (Testing/QA)
 * DoD: Feature test suite covers all 10 required scenarios and passes
 * via `php artisan test`.
 */
class SupportApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Order::create([
            'order_number' => 'ORD1001',
            'customer_name' => 'Test Customer',
            'status' => 'shipped',
            'estimated_delivery' => now()->addDays(3),
        ]);

        ReturnRequest::create([
            'order_number' => 'ORD1001',
            'return_status' => 'requested',
            'refund_status' => 'pending',
            'return_reason' => 'Test reason',
        ]);
    }

    /** TEST-01: Valid order lookup returns 200 and correct data */
    public function test_valid_order_lookup(): void
    {
        $response = $this->getJson('/api/orders/ORD1001');
        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonPath('data.status', 'shipped');
    }

    /** TEST-02: Invalid (well-formed but unknown) order number returns 404 */
    public function test_invalid_order_lookup_returns_404(): void
    {
        $response = $this->getJson('/api/orders/ORD9999');
        $response->assertStatus(404)->assertJson(['success' => false]);
    }

    /** TEST-03: Empty order number segment returns 404 (route not matched) */
    public function test_empty_order_number_input(): void
    {
        $response = $this->getJson('/api/orders/');
        $response->assertStatus(404);
    }

    /** TEST-04: Malformed order number format returns 422 */
    public function test_invalid_input_format_returns_422(): void
    {
        $response = $this->getJson('/api/orders/abc123!!');
        $response->assertStatus(422)->assertJson(['success' => false]);
    }

    /** TEST-05: Valid return/refund lookup returns 200 and correct data */
    public function test_valid_return_lookup(): void
    {
        $response = $this->getJson('/api/returns/ORD1001');
        $response->assertStatus(200)
            ->assertJsonPath('data.return_status', 'requested')
            ->assertJsonPath('data.refund_status', 'pending');
    }

    /** TEST-06: Return lookup for unknown order returns 404 */
    public function test_invalid_return_lookup_returns_404(): void
    {
        $response = $this->getJson('/api/returns/ORD9999');
        $response->assertStatus(404);
    }

    /** TEST-07: Valid order with no return row still returns sane defaults */
    public function test_order_with_no_return_row_returns_defaults(): void
    {
        Order::create([
            'order_number' => 'ORD2002',
            'customer_name' => 'No Return Customer',
            'status' => 'delivered',
        ]);

        $response = $this->getJson('/api/returns/ORD2002');
        $response->assertStatus(200)
            ->assertJsonPath('data.return_status', 'not_requested')
            ->assertJsonPath('data.refund_status', 'not_applicable');
    }

    /** TEST-08: Return instructions endpoint responds with step list */
    public function test_return_instructions_endpoint(): void
    {
        $response = $this->getJson('/api/returns-instructions');
        $response->assertStatus(200)
            ->assertJsonStructure(['success', 'data' => ['steps']]);
    }

    /** TEST-09: Dashboard page loads successfully (frontend/API integration surface) */
    public function test_dashboard_page_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200)->assertSee('Northstar Support Center');
    }

    /** TEST-10: Order number with only whitespace-equivalent value fails validation */
    public function test_whitespace_order_number_fails_validation(): void
    {
        $response = $this->getJson('/api/orders/%20%20');
        $response->assertStatus(422);
    }
}
