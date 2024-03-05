<?php

namespace App\Modules\User\Http\Controllers;

use App\Modules\User\Models\User;
use App\Modules\User\Actions\DeleteUserAction;
use Illuminate\Http\JsonResponse;

class DeleteUserController
{
    public function __invoke(
        User $user, 
        DeleteUserAction $deleteUserAction,
    ): JsonResponse
    {
        $deleteUserAction->execute($user);

        return response()->json([
            'message' => 'Success.',
        ], 200);
    }
}   