<?php

namespace App\Modules\Transaction\Actions\Category;

use App\Modules\Transaction\Models\Category;

class UpdateCategoryAction
{
    public function __construct()
    {

    }

    public function execute(Category $category, array $attributes): Category
    {
        $category->update($attributes);

        return $category;
    }
}
