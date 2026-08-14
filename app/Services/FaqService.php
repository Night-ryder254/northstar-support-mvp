<?php

namespace App\Services;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Collection;

class FaqService
{
    public function getFaqs(?string $category = null, ?string $search = null): Collection
    {
        return Faq::query()
            ->active()
            ->category($category)
            ->search($search)
            ->latest()
            ->get();
    }

    public function getFaqById(int $id): ?Faq
    {
        return Faq::active()->find($id);
    }
}