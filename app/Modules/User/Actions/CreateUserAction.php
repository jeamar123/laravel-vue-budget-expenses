<?php

namespace App\Modules\User\Actions;

use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role as SpatieRole;

class CreateUserAction
{
    public function __construct()
    {

    }

    public function execute(array $attributes): User
    {
        $user = User::create([
            ...$attributes,
            'password' => Hash::make($attributes['password']),
        ]);

        $user->assignRole(SpatieRole::where('name', $attributes['role'])->first());

        return $user;
    }
}
