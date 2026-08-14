<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'product_name',
        'size',
        'color',
        'stock_quantity',
        'restock_date',
    ];

    protected $casts = [
        'restock_date' => 'date',
        'stock_quantity' => 'integer',
    ];

    public function inStock(): bool
    {
        return $this->stock_quantity > 0;
    }
}
