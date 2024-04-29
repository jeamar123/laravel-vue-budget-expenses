<?php

namespace App\Modules\Transaction\Http\Controllers\Budget;

use App\Modules\Transaction\Models\Category;
use App\Modules\Transaction\Models\Transaction;
use App\Modules\Transaction\Http\Resources\CategoryResource;
use App\Modules\Transaction\Http\Resources\BudgetResource;
use Illuminate\Http\JsonResponse;
use App\Traits\TablePaginationTrait;
use Illuminate\Http\Request;

class ListBudgetsController
{
    use TablePaginationTrait;

    public function __invoke(Request $request): JsonResponse
    {
        $categories = Category::where('user_id', auth()->user()->id)
                                    ->where('type', 'expenses')
                                    ->orWhereNull('user_id')
                                    ->orderBy('created_at')
                                    ->get();
        
        foreach ($categories as $category) {
            $category['spent'] = abs(
                                    Transaction::where('user_id', auth()->user()->id)
                                        ->where('category', $category['name'])
                                        ->sum('total')
                                );
            $category['remaining'] = ($category['budget'] - $category['spent']);
        }

        $table_headers = [
            ['label' => 'Category', 'key' => 'name'],
            ['label' => 'Budget', 'key' => 'budget'],
            ['label' => 'Spent', 'key' => 'spent'],
            ['label' => 'Remaining', 'key' => 'remaining'],
        ];

        $isPaginate = $request->get('paginate', true);

        if($isPaginate === 'true' || $isPaginate === true){
            $result = $this->paginateTableWithMeta(
                $categories,
                $request->get('perPage', 10),
                BudgetResource::class,
                $table_headers
            );

            return response()->json([
                ...$result,
            ], 200);
        }else{
            return response()->json([
                'headers' => $table_headers,
                'data' => $categories
            ], 200);
        }
    }
}   