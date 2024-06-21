<?php

namespace App\Modules\User\Http\Controllers;

use Illuminate\Http\JsonResponse;

class CurrentUserController
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'user' => auth()->user(),
            'message' => 'Success',
        ], 200);
    }
}   