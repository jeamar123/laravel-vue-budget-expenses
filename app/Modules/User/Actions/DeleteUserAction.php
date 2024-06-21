<?php

namespace App\Modules\User\Actions;

use App\Modules\User\Models\User;

class DeleteUserAction
{
    public function execute(User $user): User
    {
        $user->delete();

        return $user;
    }
}
