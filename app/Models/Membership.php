<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Membership extends Pivot
{
    protected $table = 'memberships';

    protected $fillable = [
        'colocation_id',
        'user_id',
        'role',
        'joined_at',
        'left_at',
    ];

    protected $dates = [
        'joined_at',
        'left_at',
    ];
}