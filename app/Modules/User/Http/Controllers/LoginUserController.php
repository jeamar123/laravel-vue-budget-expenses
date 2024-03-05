<?php

namespace App\Modules\User\Http\Controllers;

use App\Modules\User\Models\User;
use Illuminate\Http\JsonResponse;
use App\Modules\User\Actions\LoginUserAction;
use App\Modules\User\Http\Requests\LoginUserRequest;

class LoginUserController
{
    public function __invoke(
        LoginUserRequest $request,
        LoginUserAction $login,
    ): JsonResponse 
    {
        $user = $login->execute(
            $request->only('username', 'password'),
            $request->input('remember', false)
        );

        if ($user) {
            activity()
                ->event($user->role . ':logged in')
                ->withProperties([
                    'user' => $user
                ])
                ->log($user->role . ':logged in');

            return response()->json([
                'token' => $user->createToken('apiToken')->plainTextToken,
                'message' => 'Success',
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid Credentials',
        ], 400);
    }
}   