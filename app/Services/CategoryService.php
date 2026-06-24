<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getActiveCategories()
    {
        return Category::active()->ordered()->get();
    }

    public function getCategoriesWithProjectCount()
    {
        return Category::active()
            ->withCount('projects')
            ->ordered()
            ->get();
    }
}
