<?php

namespace App\Modules\User\Actions;

use App\Modules\User\Models\User;

class UpdateUserAction
{
    public function __construct()
    {

    }

    public function execute(User $user, array $attributes): User
    {
        $user->update($attributes);

        return $user;
    }
}
