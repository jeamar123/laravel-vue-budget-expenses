<?php

namespace App\Modules\User\Http\Controllers\Account;

use App\Modules\User\Models\Account;
use App\Modules\User\Http\Requests\Account\CreateAccountRequest;
use App\Modules\User\Actions\Account\CreateAccountAction;
use Illuminate\Http\JsonResponse;

class CreateAccountController
{
    public function __invoke(
        CreateAccountRequest $request,
        CreateAccountAction $createAccountAction,
    ): JsonResponse
    {
        $createAccountAction->execute($request->validated());

        return response()->json([
            'message' => 'Success'
        ], 201);
    }
}   