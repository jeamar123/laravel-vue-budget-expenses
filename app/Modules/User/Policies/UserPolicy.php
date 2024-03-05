<?php

namespace App\Modules\User\Policies;

use App\Modules\User\Models\User;

class UserPolicy
{
    public function list(User $user): bool
    {
        return $user->can('user:view');
    }

    public function show(User $user): bool
    {
        return $user->can('user:view');
    }

    public function create(User $user): bool
    {
        return $user->can('user:create');
    }

    public function update(User $user): bool
    {
        return $user->can('user:update');
    }

    public function delete(User $user): bool
    {
        return $user->can('user:delete');
    }
}
