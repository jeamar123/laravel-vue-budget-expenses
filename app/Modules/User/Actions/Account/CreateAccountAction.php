<?php

namespace App\Modules\User\Actions\Account;

use App\Modules\User\Models\Account;

class CreateAccountAction
{
    public function __construct()
    {

    }

    public function execute(array $attributes): Account
    {
        $account = Account::create([
            ...$attributes,
            'user_id' => auth()->user()->id
        ]);

        return $account;
    }
}
