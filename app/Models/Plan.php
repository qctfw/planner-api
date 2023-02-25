<?php

namespace App\Models;

use App\Enums\PlanStatus;
use App\Traits\RandomID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use RandomID, HasFactory;

    /**
     * {@inheritDoc}
     */
    protected $keyType = 'string';

    /**
     * {@inheritDoc}
     */
    public $incrementing = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => PlanStatus::class,
    ];
}
