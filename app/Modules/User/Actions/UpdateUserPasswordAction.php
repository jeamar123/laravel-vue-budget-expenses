<?php

namespace App\Modules\User\Actions;

use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateUserPasswordAction
{
    public function __construct()
    {

    }

    public function execute(User $user, array $attributes): User
    {
        $user->update([
            'password' => Hash::make($attributes['new_password'])
        ]);

        return $user;
    }
}
