<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Transaction\Models\Category;

class CategorySeeder extends Seeder
{
    protected const USERS = [
        ADMIN_ID,
        SUPER_ADMIN_ID,
        USER_ID
    ];

    protected const CATEGORIES = [
        [
            'name' => 'food',
            'type' => 'expenses'
        ],
        [
            'name' => 'home',
            'type' => 'expenses'
        ],
        [
            'name' => 'salary',
            'type' => 'income'
        ],
        [
            'name' => 'allowance',
            'type' => 'income'
        ],
    ];

    public function run()
    {
        
        foreach (self::USERS as $user) {
            foreach (self::CATEGORIES as $category) {
                Category::create([
                    'user_id' => $user,
                    ...$category
                ]);
            }
        }
    }
}
