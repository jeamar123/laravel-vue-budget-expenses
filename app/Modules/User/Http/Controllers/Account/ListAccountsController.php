<?php

namespace App\Modules\User\Http\Controllers\Account;

use App\Modules\User\Models\Account;
use App\Modules\User\Http\Resources\AccountResource;
use Illuminate\Http\JsonResponse;
use App\Traits\TablePaginationTrait;
use Illuminate\Http\Request;

class ListAccountsController
{
    use TablePaginationTrait;

    public function __invoke(Request $request): JsonResponse
    {
        $categories = Account::where('user_id', auth()->user()->id)
                                    ->orWhereNull('user_id')
                                    ->orderBy('created_at')
                                    ->get();

        $table_headers = [
            ['label' => 'Name', 'key' => 'name'],
        ];

        $result = $this->paginateTableWithMeta(
            $categories,
            $request->get('perPage', 10),
            AccountResource::class,
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