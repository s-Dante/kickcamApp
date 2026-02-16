<?php

namespace App\Enums;

enum QuestionDifficultyEnum: string
{
    case EASY = 'easy';
    case MEDIUM = 'medium';
    case HARD = 'hard';

    public function label(): string 
    {
        return match($this)
        {
            self::EASY => 'facil',
            self::MEDIUM => 'moderado',
            self::HARD => 'dificil',
        };
    }
}
