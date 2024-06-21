<?php

namespace App\Modules\User\Actions\Account;

use App\Modules\User\Models\Account;

class UpdateAccountAction
{
    public function __construct()
    {

    }

    public function execute(Account $account, array $attributes): Account
    {
        $account->update($attributes);

        return $account;
    }
}
