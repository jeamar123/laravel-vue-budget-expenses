<?php

namespace App\Modules\User\Actions;

use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role as SpatieRole;
use App\Modules\User\Actions\Account\CreateAccountAction;
use App\Modules\Transaction\Actions\Category\CreateCategoryAction;

class CreateUserAction
{
    public const ACCOUNTS = [ 'cash', 'bank account', 'credit_card', 'debit_card' ];
    public const CATEGORIES = [
        [
            'name' => 'food',
            'type' => 'expenses'
        ],
        [
            'name' => 'home',
            'type' => 'expenses'
        ],
        [
            'name' => 'salary',
            'type' => 'income'
        ],
        [
            'name' => 'allowance',
            'type' => 'income'
        ],
    ];

    public function __construct(
        protected CreateAccountAction $createAccountAction,
        protected CreateCategoryAction $createCategoryAction
    )
    {}

    public function execute(array $attributes): User
    {
        $attributes['role'] = isset($attributes['role']) ? isset($attributes['role']) : 'user';

        $user = User::create([
            ...$attributes,
            'password' => Hash::make($attributes['password']),
        ]);
        
        $user->assignRole(SpatieRole::where('name', $attributes['role'])->first());

        foreach (self::ACCOUNTS as $account) {
            $this->createAccountAction->execute([
                'name' => $account,
                'user_id' => $user->id
            ]);
        }

        foreach (self::CATEGORIES as $category) {
            $this->createCategoryAction->execute([
                ...$category,
                'user_id' => $user->id
            ]);
        }

        return $user;
    }
}
