<?php

namespace App\Modules\Transaction\Http\Controllers;

use App\Modules\Transaction\Models\Transaction;
use App\Modules\Transaction\Models\Category;
use Illuminate\Http\JsonResponse;

class SummaryTransactionsController
{
    public function __invoke(): JsonResponse
    {   
        $transactions = Transaction::orderBy('date')->get();
        
        $income = 0;        
        $expenses = 0;        

        $incomeCategories = ['salary', 'bonus', 'allowance'];

        foreach ($transactions as $value) {
            $test = 0;
            if(in_array($value->category, $incomeCategories)){
                $income += $value->total;
            }else{
                $expenses += $value->total;
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