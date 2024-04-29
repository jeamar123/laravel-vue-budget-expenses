<?php

namespace App\Modules\Transaction\Http\Controllers\Category;

use App\Modules\Transaction\Models\Category;
use App\Modules\Transaction\Http\Requests\Category\UpdateCategoryRequest;
use App\Modules\Transaction\Actions\Category\UpdateCategoryAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateCategoryController
{
    public function __invoke(
        Category $category, 
        UpdateCategoryRequest $request, 
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