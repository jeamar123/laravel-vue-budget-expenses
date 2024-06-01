<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\User\Models\Account;

class AccountSeeder extends Seeder
{
    protected const ACCOUNTS = [
        [
            'user_id' => ADMIN_ID,
            'name' => 'cash',
        ],
        [
            'user_id' => ADMIN_ID,
            'name' => 'bank account',
        ],
        [
            'user_id' => ADMIN_ID,
            'name' => 'credit card',
        ],
        [
            'user_id' => ADMIN_ID,
            'name' => 'debit card',
        ],
    ];

    public function run()
    {
        foreach (self::ACCOUNTS as $account) {
            Account::create($account);
        }
    }
}
