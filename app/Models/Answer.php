<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    /** @use HasFactory<\Database\Factories\AnswerFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'answer_text',
        'is_correct',
        'question_id'
    ];

    protected $casts = [
        'answer_text' => 'string',
        'is_correct' => 'boolean',
        'question_id' => 'integer'
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }
}
