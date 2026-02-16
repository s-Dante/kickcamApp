<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Enums\MultimediaCategoryEnum;
use App\Models\Country;

class Multimedia extends Model
{
    /** @use HasFactory<\Database\Factories\MultimediaFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'file_url',
        'category',
        'country_id'
    ];

    protected $casts = [
        'file_url' => 'string',
        'category' => MultimediaCategoryEnum::class,
        'country_id' => 'integer'
    ];

    //Quiza se pueda robustecer aun mas el modelo con accesors o mas relacines

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function scopeByCategory($query, MultimediaCategoryEnum $category)
    {
        return $query->where('category', $category);
    }
}
