<?php

namespace App\Modules\User\Http\Controllers\Account;

use App\Modules\User\Models\Account;
use App\Modules\User\Actions\Account\DeleteAccountAction;
use Illuminate\Http\JsonResponse;

class DeleteAccountController
{
    public function __invoke(
        Account $account, 
        DeleteAccountAction $deleteAccountAction,
    ): JsonResponse
    {
        $deleteAccountAction->execute($account);

        return response()->json([
            'message' => 'Success.',
        ], 200);
    }
}   