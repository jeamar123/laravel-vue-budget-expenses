<?php

namespace App\Modules\Transaction\Http\Controllers;

use App\Modules\Transaction\Models\Transaction;
use App\Modules\Transaction\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SummaryTransactionsController
{
    public function __invoke(Request $request): JsonResponse
    {   
        $start = date('Y-m-d 00:00:00', strtotime($request->get('start', date('Y-m-d 00:00:00'))));
        $end = date('Y-m-d 23:59:59', strtotime($request->get('end', date('Y-m-d 23:59:59'))));

        $transactions = Transaction::where('user_id', auth()->user()->id)
                                    ->orderBy('date')
                                    ->whereBetween('date', [$start, $end])
                                    ->with('category')
                                    ->get();
        
        $income = 0;        
        $expenses = 0;        

        foreach ($transactions as $transaction) {
            if($transaction->category){
                if($transaction->category['type'] == 'income'){
                    $income += $transaction->total;
                }else{
                    $expenses += $transaction->total;
                }
            }
        }

        return response()->json([
            'summary' => [
                'income' => $income,
                'expenses' => $expenses,
                'balance' => $income - abs($expenses),
            ],
        ], 200);
    }
}   