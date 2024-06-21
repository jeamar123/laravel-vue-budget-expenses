<?php

namespace App\Modules\Transaction\Http\Controllers;

use App\Modules\Transaction\Models\Transaction;
use App\Modules\Transaction\Http\Requests\CreateTransactionRequest;
use App\Modules\Transaction\Actions\CreateTransactionAction;
use Illuminate\Http\JsonResponse;

class CreateTransactionController
{
    public function __invoke(
        CreateTransactionRequest $request,
        CreateTransactionAction $createTransactionAction,
    ): JsonResponse
    {
        $createTransactionAction->execute($request->validated());

        return response()->json([
            'message' => 'Success'
        ], 201);
    }
}   