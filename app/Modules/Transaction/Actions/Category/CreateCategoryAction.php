<?php

namespace App\Modules\Transaction\Actions\Category;

use App\Modules\Transaction\Models\Category;

class CreateCategoryAction
{
    public function __construct()
    {

    }

    public function execute(array $attributes): Category
    {
        $category = Category::create([
            ...$attributes,
            'user_id' => isset($attributes['user_id']) ? $attributes['user_id'] : auth()->user()->id
        ]);

        return $category;
    }
}
