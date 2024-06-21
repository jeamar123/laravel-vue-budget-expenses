<?php

namespace App\Modules\Transaction\Http\Controllers\Dashboard;

use App\Modules\Transaction\Models\Transaction;
use App\Modules\Transaction\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Datetime;

class BalanceReportController
{
    public function __invoke(Request $request): JsonResponse
    {   
        $start = date('Y-m-d 00:00:00', strtotime($request->get('start', date('Y-m-d 00:00:00'))));
        $end = date('Y-m-d 23:59:59', strtotime($request->get('end', date('Y-m-d 23:59:59'))));

        $transactions = Transaction::where('user_id', auth()->user()->id)
                                    ->orderBy('date')
                                    ->whereBetween('date', [$start, $end])
                                    ->get();
        
        $income = 0;        
        $expenses = 0;         

        foreach ($transactions as $value) {
            $category = Category::where('name', $value->category)->first();
            if($category){
                if($category['type'] == 'income'){
                    $income += $value->total;
                }else{
                    $expenses += $value->total;
                }
            }
        }

        $monthly_arr = [];

        $year_start = date('Y-m-d 00:00:00', strtotime('January 1st'));
        $year_end = date('Y-m-d 23:59:59', strtotime('December 31st'));

        $year_transactions = Transaction::where('user_id', auth()->user()->id)
                                    ->orderBy('date')
                                    ->whereBetween('date', [$year_start, $year_end])
                                    ->get();

        $year = date('Y');
        $months = Collection::range(1, 12)->map(function ($month) use ($year) {
            return [
                'start' => (new DateTime("$year-$month-01"))->format('Y-m-d'),
                'end' => (new DateTime("$year-$month-01"))->format('Y-m-t'),
            ];
        })->toArray();

        foreach ($months as $month) {
            $month_transactions = Transaction::where('user_id', auth()->user()->id)
                                    ->orderBy('date')
                                    ->whereBetween('date', [$month['start'], $month['end']])
                                    ->get();

            $month_income = 0;
            $month_expenses = 0;      
            $month_balance = 0;      

            foreach ($month_transactions as $value) {
                $category = Category::where('name', $value->category)->first();
                if($category){
                    if($category['type'] == 'income'){
                        $month_income += $value->total;
                    }else{
                        $month_expenses += $value->total;
                    }
                }
            }

            array_push($monthly_arr, [
                'label' => $month['end'],
                'income' => $month_income,
                'expenses' => $month_expenses,
                'balance' => $month_income - abs($month_expenses),
            ]);
        }

        return response()->json([
            'current' => [
                'income' => $income,
                'expenses' => $expenses,
                'balance' => $income - abs($expenses),
            ],
            'monthly' => $monthly_arr,
        ], 200);
    }
}   