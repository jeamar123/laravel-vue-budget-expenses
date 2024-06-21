<?php

namespace App\Modules\User\Http\Controllers;

use App\Modules\User\Models\User;
use App\Modules\User\Http\Requests\UpdateUserPasswordRequest;
use App\Modules\User\Actions\UpdateUserPasswordAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateUserPasswordController
{
    public function __invoke(
        UpdateUserPasswordRequest $request, 
        UpdateUserPasswordAction $updateUserPasswordAction
    ): JsonResponse
    {   
        /** @var \App\Modules\User\Models\User $user */
        $user = $request->user();

        $checkCurrentPassword = Hash::check($request->get('current_password'), $user->password);

        if(!$checkCurrentPassword){
            return response()->json([
                'message' => 'Current Password is incorrect.',
            ], 500);
        }

        $updateUserPasswordAction->execute($user, $request->validated());

        return response()->json([
            'message' => 'Success',
        ], 200);
    }
}   