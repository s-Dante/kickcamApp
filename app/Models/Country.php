<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Multimedia;
use App\Models\Question;

class Country extends Model
{
    /** @use HasFactory<\Database\Factories\CountryFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'flag_url',
        'ar_target_url',
        'slug'
    ];

    protected $casts = [
        'name' => 'string',
        'flag_url' => 'string',
        'ar_target_url' => 'string',
        'slug' => 'string'
    ];


    public function multimedia(): HasMany
    {
        return  $this->hasMany(Multimedia::class, 'id');
    }

    public function question(): HasMany
    {
        return $this->hasMany(Question::class, 'id');
    }
}
