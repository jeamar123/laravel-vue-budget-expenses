<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Transaction\Models\Category;

class CategorySeeder extends Seeder
{
    protected const CATEGORIES = [
        [
            'user_id' => ADMIN_ID,
            'name' => 'food',
            'type' => 'expenses'
        ],
        [
            'user_id' => ADMIN_ID,
            'name' => 'home',
            'type' => 'expenses'
        ],
        [
            'user_id' => ADMIN_ID,
            'name' => 'salary',
            'type' => 'income'
        ],
        [
            'user_id' => ADMIN_ID,
            'name' => 'allowance',
            'type' => 'income'
        ],
    ];

    public function run()
    {
        foreach (self::CATEGORIES as $category) {
            Category::create($category);
        }
    }
}
