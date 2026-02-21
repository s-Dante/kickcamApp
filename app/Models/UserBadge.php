<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBadge extends Model
{
    /** @use HasFactory<\Database\Factories\UserBadgeFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'earned_at',
        'badge_id',
        'user_id',
    ];

    protected $casts = [
        'earned_at' => 'datetime',
        'badge_id' => 'integer',
        'user_id' => 'integer'
    ];
}
