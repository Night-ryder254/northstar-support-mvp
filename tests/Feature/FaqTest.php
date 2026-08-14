<?php

namespace Tests\Feature;

use App\Models\Faq;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * TASK-08: FAQ / self-service help API test suite
 * Owner: Thando
 * DoD: Test suite covers list, single lookup, missing id, malformed id,
 *      category filter, and search, all passing via `php artisan test`.
 */
class FaqTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_a_list_of_active_faqs()
    {
        Faq::factory()->count(3)->create(['active' => true]);
        Faq::factory()->create(['active' => false]);

        $response = $this->getJson('/api/faqs');

        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonCount(3, 'data');
    }

    public function test_returns_a_single_faq_by_id()
    {
        $faq = Faq::factory()->create();

        $response = $this->getJson("/api/faqs/{$faq->id}");

        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonPath('data.question', $faq->question);
    }

    public function test_returns_404_for_a_missing_faq()
    {
        $response = $this->getJson('/api/faqs/999999');

        $response->assertStatus(404)
            ->assertJson(['success' => false]);
    }

    public function test_returns_422_for_a_malformed_faq_id()
    {
        $response = $this->getJson('/api/faqs/not-a-number');

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_filters_faqs_by_category()
    {
        Faq::factory()->create(['category' => 'returns']);
        Faq::factory()->create(['category' => 'delivery']);

        $response = $this->getJson('/api/faqs?category=returns');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_searches_faqs_by_keyword()
    {
        Faq::factory()->create(['question' => 'When will I get my refund?']);
        Faq::factory()->create(['question' => 'How long is delivery?']);

        $response = $this->getJson('/api/faqs?search=refund');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }
}