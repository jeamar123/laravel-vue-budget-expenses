<?php

namespace App\Modules\User\Policies;

use App\Modules\User\Models\Account;
use App\Modules\User\Models\User;

class AccountPolicy
{
    public function list(User $user): bool
    {
        return $user->can('account:view');
    }

    public function show(User $user): bool
    {
        return $user->can('account:view');
    }

    public function create(User $user): bool
    {
        return $user->can('account:create');
    }

    public function update(User $user): bool
    {
        return $user->can('account:update');
    }

    public function delete(User $user): bool
    {
        return $user->can('account:delete');
    }

}
