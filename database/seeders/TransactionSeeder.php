<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Modules\Transaction\Models\Transaction;
use App\Enums\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Spatie\Permission\Models\Role as SpatieRole;

class TransactionSeeder extends Seeder
{
    protected const TRANSACTIONS = [
        [
            'user_id' => ADMIN_ID,
            'description' => 'Lunch',
            'total' => -330,
            'source' => 'cash',
            'category' => 'food',
            'date' => '2024-04-16 12:30:00',
        ],
        [
            'user_id' => ADMIN_ID,
            'description' => 'Gas',
            'total' => -1857,
            'source' => 'credit card',
            'category' => 'car',
            'date' => '2024-04-16 12:31:00',
        ],
        [
            'user_id' => ADMIN_ID,
            'description' => 'Airlst',
            'total' => 50000,
            'source' => 'bank account',
            'category' => 'salary',
            'date' => '2024-04-16 12:32:00',
        ],
        [
            'user_id' => ADMIN_ID,
            'description' => 'Dinner',
            'total' => -540,
            'source' => 'cash',
            'category' => 'food',
            'date' => '2024-04-16 12:33:00',
        ],
    ];

    public function run()
    {
        foreach (self::TRANSACTIONS as $transaction) {
            Transaction::create($transaction);
        }
    }
}
