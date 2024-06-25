<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\User\Models\Account;

class AccountSeeder extends Seeder
{
    protected const USERS = [
        ADMIN_ID,
        SUPER_ADMIN_ID,
        USER_ID
    ];
    
    protected const ACCOUNTS = [
        'cash',
        'bank account',
        'credit card',
        'debit card',
    ];

    public function run()
    {
        foreach (self::USERS as $user) {
            foreach (self::ACCOUNTS as $account) {
                Account::create([
                    'user_id' => $user,
                    'name' => $account,
                ]);
            }
        }
    }
}
