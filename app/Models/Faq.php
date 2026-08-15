<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'answer', 'category', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeCategory($query, ?string $category)
    {
        return $category ? $query->where('category', $category) : $query;
    }

    public function scopeSearch($query, ?string $term)
    {
        return $term
            ? $query->where(function ($q) use ($term) {
                $q->where('question', 'like', "%{$term}%")
                  ->orWhere('answer', 'like', "%{$term}%");
            })
            : $query;
    }
}