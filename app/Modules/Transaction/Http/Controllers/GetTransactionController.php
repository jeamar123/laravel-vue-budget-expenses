<?php

namespace App\Modules\Transaction\Http\Controllers;

use App\Modules\Transaction\Models\Transaction;
use Illuminate\Http\JsonResponse;

class GetTransactionController
{
    public function __invoke(
      Transaction $transaction, 
    ): JsonResponse
    {
        if($transaction){
            return response()->json([
                'transaction' => $transaction,
                'message' => 'Success',
            ], 200);
        }

        return response()->json([
            'message' => 'Not found',
        ], 404);
    }
}   