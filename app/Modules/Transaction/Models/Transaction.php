<?php

namespace App\Modules\Transaction\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Concerns\UuidPrimaryKey;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Transaction extends Model
{   
    use HasFactory,
        UuidPrimaryKey,
        LogsActivity,
        HasRoles;

    protected $fillable = [
        'description',
        'user_id',
        'total',
        'source',
        'category',
        'date'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logAll()
                ->useLogName('transaction');
    }
}
