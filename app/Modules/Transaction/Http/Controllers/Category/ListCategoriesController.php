<?php

namespace App\Modules\Transaction\Http\Controllers\Category;

use App\Modules\Transaction\Models\Category;
use App\Modules\Transaction\Models\Transaction;
use App\Modules\Transaction\Http\Resources\CategoryResource;
use Illuminate\Http\JsonResponse;
use App\Traits\TablePaginationTrait;
use Illuminate\Http\Request;

class ListCategoriesController
{
    use TablePaginationTrait;

    public function __invoke(Request $request): JsonResponse
    {
        $categories = Category::where('user_id', auth()->user()->id)
                                    ->orWhereNull('user_id')
                                    ->orderBy('created_at')
                                    ->get();

        $table_headers = [
            ['label' => 'Category', 'key' => 'name'],
        ];

        $isPaginate = $request->get('paginate', true);

        if($isPaginate === 'true' || $isPaginate === true){
            $result = $this->paginateTableWithMeta(
                $categories,
                $request->get('perPage', 10),
                CategoryResource::class,
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