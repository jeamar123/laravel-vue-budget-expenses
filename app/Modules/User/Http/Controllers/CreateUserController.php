<?php

namespace App\Modules\User\Http\Controllers;

use App\Modules\User\Models\User;
use App\Modules\User\Http\Requests\CreateUserRequest;
use App\Modules\User\Actions\CreateUserAction;
use Illuminate\Http\JsonResponse;

class CreateUserController
{
    public function __invoke(
        CreateUserRequest $request,
        CreateUserAction $createUserAction,
    ): JsonResponse
    {
        $createUserAction->execute($request->validated());

        return response()->json([
            'message' => 'Success'
        ], 201);
    }
}   