<?php

namespace App\Modules\Transaction\Http\Controllers\Budget;

use App\Modules\Transaction\Models\Category;
use App\Modules\Transaction\Http\Requests\Budget\UpdateBudgetRequest;
use App\Modules\Transaction\Actions\Category\UpdateCategoryAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateBudgetController
{
    public function __invoke(
        Category $category, 
        UpdateBudgetRequest $request, 
        UpdateCategoryAction $updateCategoryAction
    ): JsonResponse
    {
        $updateCategoryAction->execute($category, $request->validated());

        return response()->json([
            'message' => 'Success',
            'category' => $category,
        ], 200);
    }
}   