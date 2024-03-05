<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum Role: string
{
    case GOD_ADMIN = 'god_admin';
    case SUPER_ADMIN = 'super_admin';
    case USER = 'user';


    public static function values(): Collection
    {
        return Collection::make(self::cases())->map(fn (self $case) => [
            'label' => $case->getLabel(),
            'value' => $case->value,
        ]);
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::GOD_ADMIN => 'God Admin',
            self::SUPER_ADMIN => 'Super Admin',
            self::USER => 'User',
        };
    }
}

