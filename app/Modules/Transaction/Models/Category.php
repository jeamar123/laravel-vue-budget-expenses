<?php

namespace App\Modules\Transaction\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Concerns\UuidPrimaryKey;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Modules\Transaction\Models\Transaction;

class Category extends Model
{   
    use HasFactory,
        UuidPrimaryKey,
        LogsActivity,
        HasRoles;

    protected $fillable = [
        'user_id',
        'name',
        'budget',
        'type'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logAll()
                ->useLogName('category');
    }

    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
