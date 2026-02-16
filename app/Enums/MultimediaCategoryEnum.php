<?php

namespace App\Enums;

enum MultimediaCategoryEnum: string
{
    case IMAGE = 'image';
    case VIDEO = 'video';
    case AR = '3d_model';

    public function label(): string 
    {
        return match($this)
        {
            self::IMAGE => 'imagen',
            self::VIDEO => 'video',
            self::AR => 'modelo 3D',
        };
    }
}

