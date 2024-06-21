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
                                    ->orderBy('name')
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

        $result = $this->paginateTableWithMeta(
                    $categories,
                    $request->get('perPage', 10),
                    BudgetResource::class,
                    $table_headers,
                    filter_var(
                        $request->get('paginate', false),
                        FILTER_VALIDATE_BOOLEAN,
                        FILTER_NULL_ON_FAILURE
                    )
                );

        return response()->json([
            ...$result,
        ], 200);
    }
}   