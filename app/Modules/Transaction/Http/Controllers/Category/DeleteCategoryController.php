<?php

namespace App\Modules\Transaction\Http\Controllers\Category;

use App\Modules\Transaction\Models\Category;
use App\Modules\Transaction\Actions\Category\DeleteCategoryAction;
use Illuminate\Http\JsonResponse;

class DeleteCategoryController
{
    public function __invoke(
        Category $category, 
        DeleteCategoryAction $deleteCategoryAction,
    ): JsonResponse
    {
        $deleteCategoryAction->execute($category);

        return response()->json([
            'message' => 'Success.',
        ], 200);
    }
}   