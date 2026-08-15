<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

/**
 * TASK-08: Seed FAQ / self-service help data
 * Owner: Thando
 * DoD: Seeder inserts a realistic set of FAQs across categories,
 * verified via `php artisan db:seed`.
 */
class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'How long does delivery take?',
                'answer' => 'Standard delivery takes 3-5 business days. Express delivery takes 1-2 business days.',
                'category' => 'delivery',
                'active' => true,
            ],
            [
                'question' => 'How do I track my order?',
                'answer' => 'Once your order ships, you\'ll receive a tracking link by email and SMS. You can also check status via the order number on our support page.',
                'category' => 'delivery',
                'active' => true,
            ],
            [
                'question' => 'What is your return policy?',
                'answer' => 'Items can be returned within 30 days of delivery, provided they are unused and in original packaging.',
                'category' => 'returns',
                'active' => true,
            ],
            [
                'question' => 'How do I start a return?',
                'answer' => 'Go to Orders, select the item, and click "Request Return". You\'ll get a prepaid shipping label by email.',
                'category' => 'returns',
                'active' => true,
            ],
            [
                'question' => 'When will I get my refund?',
                'answer' => 'Refunds are processed within 5-7 business days after we receive and inspect the returned item.',
                'category' => 'refunds',
                'active' => true,
            ],
            [
                'question' => 'Can I cancel my order?',
                'answer' => 'Orders can be cancelled for free within 1 hour of placing them, as long as they haven\'t started processing.',
                'category' => 'orders',
                'active' => true,
            ],
            [
                'question' => 'How do I change my shipping address?',
                'answer' => 'Contact support immediately with your order number. Address changes are only possible before the order ships.',
                'category' => 'orders',
                'active' => true,
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept major credit/debit cards, mobile money, and select digital wallets at checkout.',
                'category' => 'orders',
                'active' => true,
            ],
            [
                'question' => 'Do you ship internationally?',
                'answer' => 'Currently we only ship within the country. International shipping is on our roadmap.',
                'category' => 'delivery',
                'active' => true,
            ],
            [
                'question' => 'An item arrived damaged, what do I do?',
                'answer' => 'Please contact support within 48 hours of delivery with photos of the damage, and we\'ll arrange a free replacement or refund.',
                'category' => 'returns',
                'active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}