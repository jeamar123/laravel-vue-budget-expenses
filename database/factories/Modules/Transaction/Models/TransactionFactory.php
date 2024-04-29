<?php

namespace Database\Factories\Modules\Transaction\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Transaction\Models\Transaction;
use App\Modules\User\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\Transaction\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'description' => fake()->name(),
            'total' => fake()->number(),
            'source' => 'cash',
            'category' => 'food',
            'date' => fake()->dateTime(),
        ];
    }
}
