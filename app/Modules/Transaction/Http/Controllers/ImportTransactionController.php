<?php

namespace App\Modules\Transaction\Http\Controllers;

use App\Modules\Transaction\Models\Transaction;
use App\Modules\Transaction\Http\Requests\ImportTransactionRequest;
use App\Modules\Transaction\Actions\ImportTransactionAction;
use Illuminate\Http\JsonResponse;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Http\Request;

class ImportTransactionController
{
    public function __invoke( 
        ImportTransactionRequest $request,
        ImportTransactionAction $importTransactionAction,
    ): JsonResponse 
    {
        $result = $importTransactionAction->execute($request->validated());
        
        return response()->json([
            'imported' => $result['collection'],
            'sucessful' => $result['success'],
            'failed' => $result['failed'],
            'message' => 'Success',
        ], 201);
    }
}