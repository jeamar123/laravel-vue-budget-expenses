<?php

namespace App\Modules\User\Http\Controllers;

use App\Modules\User\Models\User;
use Illuminate\Http\JsonResponse;

class GetUserController
{
    public function __invoke(
      User $user, 
    ): JsonResponse
    {
        if($user){
            return response()->json([
                'user' => $user,
                'message' => 'Success',
            ], 200);
        }

        return response()->json([
            'message' => 'Not found',
        ], 404);
    }
}   