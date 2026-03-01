<?php

declare(strict_types=1);

namespace App\Enums;

enum BadgeTypeEnum: string
{
    case GENERAL = 'general';
    case FLAG = 'flag';
    case SHIELD = 'shield';
    case BALL = 'ball';
    case FIFA_LOGO = 'fifa_logo';
    case POSTER = 'poster';
}
