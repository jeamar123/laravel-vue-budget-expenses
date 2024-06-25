<?php

namespace App\Modules\Transaction\Http\Controllers;

use App\Modules\Transaction\Models\Transaction;
use App\Modules\Transaction\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionsCategoryController
{
    public function __invoke(Request $request): JsonResponse
    {   
        $start = date('Y-m-d 00:00:00', strtotime($request->get('start', date('Y-m-d 00:00:00'))));
        $end = date('Y-m-d 23:59:59', strtotime($request->get('end', date('Y-m-d 23:59:59'))));

        $result = [];

        $transactions = Transaction::where('user_id', auth()->user()->id)
                                    ->orderBy('date')
                                    ->whereBetween('date', [$start, $end])
                                    ->with('category')
                                    ->get();
        
        $categories = Category::where('user_id', auth()->user()->id)
                                ->orderBy('name')
                                ->where('type', 'expenses')
                                ->get();      

        foreach ($categories as $category) {
            array_push($result, [
                'name' => $category['name'],
                'total' => $transactions->where('category.name', $category['name'])->sum('total')
            ]);
        }

        return response()->json([
            'data' => $result,
            'trans' => $transactions
        ], 200);
    }
}   