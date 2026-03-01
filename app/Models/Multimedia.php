<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\MultimediaCategoryEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Multimedia extends Model
{
    /** @use HasFactory<\Database\Factories\MultimediaFactory> */
    use HasFactory;

    protected $fillable = [
        'file_url',
        'category',
        'country_id',
    ];

    protected $casts = [
        'file_url' => 'string',
        'category' => MultimediaCategoryEnum::class,
        'country_id' => 'integer',
    ];

    // Quiza se pueda robustecer aun mas el modelo con accesors o mas relacines

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function scopeByCategory($query, MultimediaCategoryEnum $category)
    {
        return $query->where('category', $category);
    }
}
