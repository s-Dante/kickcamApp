<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    /** @use HasFactory<\Database\Factories\CountryFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'name',
        'flag_url',
        'ar_target_url',
        'slug',
    ];

    protected $casts = [
        'name' => 'string',
        'flag_url' => 'string',
        'ar_target_url' => 'string',
        'slug' => 'string',
    ];

    public function multimedia(): HasMany
    {
        return $this->hasMany(Multimedia::class);
    }

    public function question(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    protected function flagUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $path = parse_url($value, PHP_URL_PATH);

                return asset($path);
            }
        );
    }
}
