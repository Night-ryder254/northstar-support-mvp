<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\ReturnRequest;
use Illuminate\Database\Seeder;

/**
 * TASK-03: Seed fictional test data
 * Owner: Nigel
 * DoD: Seeder inserts >=10 orders and matching returns covering every
 * status, plus edge cases, verified via `php artisan db:seed`.
 *
 * All data below is fictional and used only for demo/testing purposes.
 */
class SupportDataSeeder extends Seeder
{
    public function run(): void
    {
        $orders = [
            ['order_number' => 'ORD1001', 'customer_name' => 'Amina Wafula',   'status' => 'processing', 'estimated_delivery' => now()->addDays(5)],
            ['order_number' => 'ORD1002', 'customer_name' => 'Brian Otieno',   'status' => 'packed',     'estimated_delivery' => now()->addDays(4)],
            ['order_number' => 'ORD1003', 'customer_name' => 'Carol Njeri',    'status' => 'shipped',    'estimated_delivery' => now()->addDays(2)],
            ['order_number' => 'ORD1004', 'customer_name' => 'Dennis Kiptoo',  'status' => 'delivered',  'estimated_delivery' => now()->subDays(1)],
            ['order_number' => 'ORD1005', 'customer_name' => 'Esther Wanjiru', 'status' => 'cancelled',  'estimated_delivery' => null],
            ['order_number' => 'ORD1006', 'customer_name' => 'Felix Mwangi',   'status' => 'shipped',    'estimated_delivery' => now()->addDays(3)],
            ['order_number' => 'ORD1007', 'customer_name' => 'Grace Achieng',  'status' => 'delivered',  'estimated_delivery' => now()->subDays(5)],
            ['order_number' => 'ORD1008', 'customer_name' => 'Hassan Ali',     'status' => 'processing', 'estimated_delivery' => now()->addDays(6)],
            ['order_number' => 'ORD1009', 'customer_name' => 'Irene Chebet',   'status' => 'packed',     'estimated_delivery' => now()->addDays(4)],
            ['order_number' => 'ORD1010', 'customer_name' => 'James Odhiambo', 'status' => 'delivered',  'estimated_delivery' => now()->subDays(10)],
            ['order_number' => 'ORD1011', 'customer_name' => 'Karen Mumbi',    'status' => 'delivered',  'estimated_delivery' => now()->subDays(2)],
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }

        $returns = [
            ['order_number' => 'ORD1004', 'return_status' => 'requested',  'refund_status' => 'pending',   'return_reason' => 'Wrong size delivered'],
            ['order_number' => 'ORD1007', 'return_status' => 'received',   'refund_status' => 'processed', 'return_reason' => 'Item damaged in transit'],
            ['order_number' => 'ORD1010', 'return_status' => 'in_transit', 'refund_status' => 'pending',   'return_reason' => 'Changed mind'],
            ['order_number' => 'ORD1005', 'return_status' => 'rejected',   'refund_status' => 'not_applicable', 'return_reason' => 'Order was cancelled before shipping'],
        ];

        foreach ($returns as $return) {
            ReturnRequest::create($return);
        }
    }
}
