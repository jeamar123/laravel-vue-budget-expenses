<?php

declare(strict_types=1);

namespace App\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @mixin Model
 */
trait UuidPrimaryKey
{
    public static function bootUuidPrimaryKey(): void
    {
        static::creating(function (Model $model): void {
            $model->id ??= Str::uuid()->toString(); // @phpstan-ignore-line
        });
    }

    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }
}
