<?php

namespace App\Modules\Transaction\Http\Controllers;

use App\Modules\Transaction\Models\Transaction;
use App\Modules\Transaction\Models\Category;
use App\Modules\Transaction\Http\Resources\TransactionResource;
use Illuminate\Http\JsonResponse;
use App\Traits\TablePaginationTrait;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ListTransactionsController
{
    use TablePaginationTrait;

    public function __invoke(Request $request): JsonResponse
    {   
        $table_headers = [
            ['label' => 'Date', 'key' => 'date'],
            ['label' => 'Note', 'key' => 'description'],
            ['label' => 'Total', 'key' => 'total'],
            ['label' => 'Source', 'key' => 'source'],
            ['label' => 'Category', 'key' => 'category.name'],
        ];

        if($request->get('all') == 'true' || $request->get('all') == true){
            $transactions = Transaction::where('user_id', auth()->user()->id)
                                                ->orderBy('date', 'desc')
                                                ->get();
            
            return response()->json([
                'headers' => $table_headers,
                'data' => $transactions,
            ], 200);
        }

        $start = date('Y-m-d 00:00:00', strtotime($request->get('start')));
        $end = date('Y-m-d 23:59:59', strtotime($request->get('end')));

        $transactions = Transaction::where('user_id', auth()->user()->id)
                                        ->orderBy('date', 'desc')
                                        ->whereBetween('date', [$start, $end])
                                        ->with('category')
                                        ->get();

        $groupDates = $transactions->groupBy(function($transaction) {
            return Carbon::parse($transaction->date)->format('Y-m-d');
        });

        $groupByDay = [];

        foreach ($groupDates as $date => $items) {
            array_push(
                $groupByDay,
                [
                    'date' => $date,
                    'items' => TransactionResource::collection($items)
                ]
            );
        }

        return response()->json([
            'headers' => $table_headers,
            'data' => $groupByDay,
            'transactions' => $transactions
        ], 200);
    }
}   