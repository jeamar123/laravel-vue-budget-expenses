<?php

namespace App\Modules\Transaction\Actions\Category;

use App\Modules\Transaction\Models\Category;

class DeleteCategoryAction
{
    public function execute(Category $category): Category
    {
        $category->delete();

        return $category;
    }
}
