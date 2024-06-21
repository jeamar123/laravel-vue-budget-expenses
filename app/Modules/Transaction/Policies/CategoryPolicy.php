<?php

namespace App\Modules\Transaction\Policies;

use App\Modules\Transaction\Models\Category;
use App\Modules\User\Models\User;

class CategoryPolicy
{
    public function list(User $user): bool
    {
        return $user->can('category:view');
    }

    public function show(User $user): bool
    {
        return $user->can('category:view');
    }

    public function create(User $user): bool
    {
        return $user->can('category:create');
    }

    public function update(User $user): bool
    {
        return $user->can('category:update');
    }

    public function delete(User $user): bool
    {
        return $user->can('category:delete');
    }

}
