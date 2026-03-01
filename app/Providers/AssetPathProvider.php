<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\CountryEnum;
use App\Enums\WorldCupEnum;
use Illuminate\Support\Str;

class AssetPathProvider
{
    public static function get3DModel(CountryEnum $country, string $type): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}");

        $fileName = Str::title($country->value).$extension;

        return asset($basePath.$fileName);
    }

    public static function getCountryFlag(CountryEnum $country, string $type): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}");

        $fileName = Str::title($country->value).$extension;

        return asset($basePath.$fileName);
    }

    public static function getCountryShield(CountryEnum $country, string $type): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}");

        $fileName = Str::title($country->value).$extension;

        return asset($basePath.$fileName);
    }

    public static function getFaceTrackingFilter(CountryEnum $country, string $type): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}");

        $fileName = Str::title($country->value).$extension;

        return asset($basePath.$fileName);
    }

    public static function getTargetAR(CountryEnum $country, string $type): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}");

        $fileName = Str::title($country->value).$extension;

        return asset($basePath.$fileName);
    }

    public static function getWorldCupBall(WorldCupEnum $worldCup, string $type): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}");

        $fileName = Str::title($worldCup->value).$extension;

        return asset($basePath.$fileName);
    }

    public static function getWorldCupFifaLogo(WorldCupEnum $worldCup, string $type): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}", '.png');

        $fileName = Str::title($worldCup->value).$extension;

        return asset($basePath.$fileName);
    }

    public static function getWorldCupPoster(WorldCupEnum $worldCup, string $type): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}", '.png');

        $fileName = Str::title($worldCup->value).$extension;

        return asset($basePath.$fileName);
    }
}
