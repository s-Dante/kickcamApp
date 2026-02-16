<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Badge extends Model
{
    /** @use HasFactory<\Database\Factories\BadgeFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'image_url',
        'description'
    ];

    protected $casts = [
        'title' => 'string',
        'image_url' => 'string',
        'description' => 'string'
    ];
}
