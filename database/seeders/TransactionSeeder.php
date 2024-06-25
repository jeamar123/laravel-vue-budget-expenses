<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Modules\Transaction\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Spatie\Permission\Models\Role as SpatieRole;

class TransactionSeeder extends Seeder
{
    protected const TRANSACTIONS = [
        [
            'user_id' => USER_ID,
            'description' => 'Lunch',
            'total' => 330,
            'source' => 'bank account',
            'category_id' => CATEGORY_ID,
            'date' => '2024-05-01 12:30:00',
        ],
        [
            'user_id' => USER_ID,
            'description' => 'Gas',
            'total' => 1857,
            'source' => 'bank account',
            'category_id' => 'car',
            'date' => '2024-05-01 12:31:00',
        ],
        [
            'user_id' => USER_ID,
            'description' => 'Airlst',
            'total' => 50000,
            'source' => 'bank account',
            'category_id' => 'salary',
            'date' => '2024-05-01 12:32:00',
        ],
        [
            'user_id' => USER_ID,
            'description' => 'Dinner',
            'total' => 540,
            'source' => 'bank account',
            'category_id' => CATEGORY_ID,
            'date' => '2024-05-01 12:33:00',
        ],
    ];

    public function run()
    {
        // foreach (self::TRANSACTIONS as $transaction) {
        //     Transaction::create($transaction);
        // }
    }
}
