<?php

namespace App\Modules\User\Http\Controllers;

use App\Modules\User\Models\User;
use App\Modules\User\Http\Requests\UpdateUserRequest;
use App\Modules\User\Actions\UpdateUserAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateUserController
{
    public function __invoke(
        User $user, 
        UpdateUserRequest $request, 
        UpdateUserAction $updateUserAction
    ): JsonResponse
    {
        $updateUserAction->execute($user, $request->validated());

        return response()->json([
            'message' => 'Success',
            'user' => $user,
        ], 200);
    }
}   