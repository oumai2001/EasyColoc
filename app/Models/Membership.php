<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Membership extends Pivot
{
    protected $casts = [
        'joined_at' => 'datetime',
        'left_at'   => 'datetime',
    ];
}