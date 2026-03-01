<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\QuestionDifficultyEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'question_text',
        'difficulty',
        'country_id',
    ];

    protected $casts = [
        'question_text' => 'string',
        'difficulty' => QuestionDifficultyEnum::class,
        'country_id' => 'integer',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function answer(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function scopeDifficulty($query, QuestionDifficultyEnum $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }
}
