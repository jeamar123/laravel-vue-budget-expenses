<?php

namespace App\Modules\User\Actions\Account;

use App\Modules\User\Models\Account;

class DeleteAccountAction
{
    public function execute(Account $account): Account
    {
        $account->delete();

        return $account;
    }
}
