<?php

namespace App\Modules\User\Http\Controllers;

use App\Modules\User\Models\User;
use App\Modules\User\Http\Requests\UpdateUserSettingsRequest;
use App\Modules\User\Actions\UpdateUserAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateUserSettingsController
{
    public function __invoke(
        UpdateUserSettingsRequest $request, 
        UpdateUserAction $updateUserAction
    ): JsonResponse
    {   
        /** @var \App\Modules\User\Models\User $user */
        $user = $request->user();
        $updateUserAction->execute($user, $request->validated());

        return response()->json([
            'message' => 'Success',
        ], 200);
    }
}   