<?php

namespace App\Modules\Transaction\Actions;

use App\Modules\Transaction\Models\Transaction;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Contracts\Auth\Factory as Auth;

class CreateTransactionAction
{
    public function __construct(protected Auth $auth)
    {

    }

    public function execute(array $attributes): Transaction
    {
        $transaction = Transaction::create([
            ...$attributes,
            'user_id' => $this->auth->user()->id
        ]);

        return $transaction;
    }
}
