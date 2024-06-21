<?php

namespace App\Modules\Transaction\Actions;

use App\Modules\Transaction\Models\Transaction;

class DeleteTransactionAction
{
    public function execute(Transaction $transaction): Transaction
    {
        $transaction->delete();

        return $transaction;
    }
}
