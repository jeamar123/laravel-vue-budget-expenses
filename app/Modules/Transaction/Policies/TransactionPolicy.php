<?php

namespace App\Modules\Transaction\Policies;

use App\Modules\Transaction\Models\Transaction;
use App\Modules\User\Models\User;

class TransactionPolicy
{
    public function list(User $user): bool
    {
        return $user->can('transaction:view');
    }

    public function show(User $user): bool
    {
        return $user->can('transaction:view');
    }

    public function create(User $user): bool
    {
        return $user->can('transaction:create');
    }

    public function update(User $user): bool
    {
        return $user->can('transaction:update');
    }

    public function delete(User $user): bool
    {
        return $user->can('transaction:delete');
    }
}
