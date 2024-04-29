<?php

namespace App\Modules\User\Http\Controllers\Account;

use App\Modules\User\Models\Account;
use App\Modules\User\Http\Requests\Account\UpdateAccountRequest;
use App\Modules\User\Actions\Account\UpdateAccountAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateAccountController
{
    public function __invoke(
        Account $account, 
        UpdateAccountRequest $request, 
        UpdateAccountAction $updateAccountAction
    ): JsonResponse
    {
        $updateAccountAction->execute($account, $request->validated());

        return response()->json([
            'message' => 'Success',
            'account' => $account,
        ], 200);
    }
}   