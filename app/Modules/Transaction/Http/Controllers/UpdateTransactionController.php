<?php

namespace App\Modules\Transaction\Http\Controllers;

use App\Modules\Transaction\Models\Transaction;
use App\Modules\Transaction\Http\Requests\UpdateTransactionRequest;
use App\Modules\Transaction\Actions\UpdateTransactionAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateTransactionController
{
    public function __invoke(
        Transaction $transaction, 
        UpdateTransactionRequest $request, 
        UpdateTransactionAction $updateTransactionAction
    ): JsonResponse
    {
        $updateTransactionAction->execute($transaction, $request->validated());

        return response()->json([
            'message' => 'Success',
            'transaction' => $transaction,
        ], 200);
    }
}   