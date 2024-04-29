<?php

namespace App\Modules\Transaction\Http\Controllers;

use App\Modules\Transaction\Models\Transaction;
use App\Modules\Transaction\Http\Resources\TransactionResource;
use Illuminate\Http\JsonResponse;
use App\Traits\TablePaginationTrait;
use Illuminate\Http\Request;

class ListTransactionsController
{
    use TablePaginationTrait;

    public function __invoke(Request $request): JsonResponse
    {   
        $start = date('Y-m-d 00:00:00', strtotime($request->get('start', date('Y-m-d 00:00:00'))));
        $end = date('Y-m-d 23:59:59', strtotime($request->get('end', date('Y-m-d 23:59:59'))));

        $transactions = Transaction::where('user_id', auth()->user()->id)
                                        ->orderBy('date')
                                        ->whereBetween('date', [$start, $end])
                                        ->get();

        $table_headers = [
            ['label' => 'Date', 'key' => 'date'],
            ['label' => 'Note', 'key' => 'description'],
            ['label' => 'Total', 'key' => 'total'],
            ['label' => 'Source', 'key' => 'source'],
            ['label' => 'Category', 'key' => 'category'],
        ];

        $result = $this->paginateTableWithMeta(
                    $transactions,
                    $request->get('perPage', 10),
                    TransactionResource::class,
                    $table_headers
                );

        return response()->json([
            ...$result,
        ], 200);
    }
}   