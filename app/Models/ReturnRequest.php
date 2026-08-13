<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    protected $table = 'returns';

    protected $fillable = [
        'order_number',
        'return_status',
        'refund_status',
        'return_reason',
    ];

    public $timestamps = true;
}
