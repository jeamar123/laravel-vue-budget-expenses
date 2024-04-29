<?php

namespace App\Modules\User\Http\Controllers;

use App\Modules\User\Models\User;
use Illuminate\Http\JsonResponse;
use App\Modules\User\Http\Resources\UserResource;

class ListUsersController
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'users' => UserResource::collection(User::get())
        ], 200);
    }
}   