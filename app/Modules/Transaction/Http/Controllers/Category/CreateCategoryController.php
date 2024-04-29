<?php

namespace App\Modules\Transaction\Http\Controllers\Category;

use App\Modules\Transaction\Models\Category;
use App\Modules\Transaction\Http\Requests\Category\CreateCategoryRequest;
use App\Modules\Transaction\Actions\Category\CreateCategoryAction;
use Illuminate\Http\JsonResponse;

class CreateCategoryController
{
    public function __invoke(
        CreateCategoryRequest $request,
        CreateCategoryAction $createCategoryAction,
    ): JsonResponse
    {
        $createCategoryAction->execute($request->validated());

        return response()->json([
            'message' => 'Success'
        ], 201);
    }
}   