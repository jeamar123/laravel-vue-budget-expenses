<?php

namespace App\Modules\Transaction\Http\Controllers;

use App\Modules\Transaction\Models\Transaction;
use App\Modules\Transaction\Actions\DeleteTransactionAction;
use Illuminate\Http\JsonResponse;

class DeleteTransactionController
{
    public function __invoke(
        Transaction $transaction, 
        DeleteTransactionAction $deleteTransactionAction,
    ): JsonResponse
    {
        $deleteTransactionAction->execute($transaction);

        return response()->json([
            'message' => 'Success.',
        ], 200);
    }
}   