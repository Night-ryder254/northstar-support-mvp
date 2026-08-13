<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'status',
        'estimated_delivery',
    ];

    protected $casts = [
        'estimated_delivery' => 'date',
    ];

    public function returnRequest()
    {
        return $this->hasOne(ReturnRequest::class, 'order_number', 'order_number');
    }
}
