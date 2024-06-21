<?php

namespace App\Modules\Transaction\Http\Controllers;

use App\Modules\Transaction\Models\Transaction;
use App\Modules\Transaction\Actions\DeleteTransactionAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BulkDeleteTransactionController
{
    public function __invoke(
        Request $request,
        DeleteTransactionAction $deleteTransactionAction,
    ): JsonResponse
    {
        $transactions = $request->get('transactions');

        foreach ($transactions as $transaction) {
            $deleteTransactionAction->execute(Transaction::find($transaction));
        }

        return response()->json([
            'test' => $request->get('transactions'),
            'message' => 'Success.',
        ], 200);
    }
}   