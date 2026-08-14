<?php

namespace Database\Seeders;

use App\Models\ReturnRequest;
use Illuminate\Database\Seeder;

class ReturnSeeder extends Seeder
{
    public function run(): void
    {
        $returns = [
            ['order_number' => 'ORD1003', 'return_status' => 'requested',  'refund_status' => 'pending',   'return_reason' => 'Wrong size'],
            ['order_number' => 'ORD1004', 'return_status' => 'received',   'refund_status' => 'processed', 'return_reason' => 'Changed mind'],
            ['order_number' => 'ORD1005', 'return_status' => 'rejected',   'refund_status' => 'processed', 'return_reason' => 'Outside return window'],
        ];

        foreach ($returns as $return) {
            ReturnRequest::create($return);
        }
    }
}