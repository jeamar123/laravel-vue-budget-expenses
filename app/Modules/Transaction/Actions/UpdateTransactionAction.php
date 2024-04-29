<?php

namespace App\Modules\Transaction\Actions;

use App\Modules\Transaction\Models\Transaction;

class UpdateTransactionAction
{
    public function __construct()
    {

    }

    public function execute(Transaction $transaction, array $attributes): Transaction
    {
        $transaction->update($attributes);

        return $transaction;
    }
}
