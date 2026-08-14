<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * "php artisan db:seed" runs this and fills the orders
     * table with a handful of made-up test orders.
     */
    public function run(): void
    {
        $orders = [
            ['order_number' => 'ORD1001', 'customer_name' => 'Amina Otieno', 'status' => 'Processing', 'estimated_delivery' => now()->addDays(5)],
            ['order_number' => 'ORD1002', 'customer_name' => 'Brian Kiptoo', 'status' => 'Packed',     'estimated_delivery' => now()->addDays(3)],
            ['order_number' => 'ORD1003', 'customer_name' => 'Cynthia Wanjiru', 'status' => 'Shipped',    'estimated_delivery' => now()->addDays(1)],
            ['order_number' => 'ORD1004', 'customer_name' => 'David Mwangi', 'status' => 'Delivered',  'estimated_delivery' => now()->subDays(2)],
            ['order_number' => 'ORD1005', 'customer_name' => 'Esther Njeri', 'status' => 'Cancelled',  'estimated_delivery' => null],
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }
    }
}
