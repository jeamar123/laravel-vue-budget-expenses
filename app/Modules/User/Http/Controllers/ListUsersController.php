<?php

namespace App\Modules\User\Http\Controllers;

use App\Modules\User\Models\User;
use Illuminate\Http\JsonResponse;

class ListUsersController
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'users' => User::get()
        ], 200);
    }
}   