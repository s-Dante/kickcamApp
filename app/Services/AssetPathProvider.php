<?php

namespace App\Services;

use App\Enums\CountryEnum;
use Illuminate\Support\Str;

class AssetPathService
{
    public static function getCountryShield(CountryEnum $country, string $type): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}", '.png');

        $fileName = Str::title($country->value) . "-soccer-shield" . $extension;
        return asset($basePath . $fileName);
    }

    public static function getCountryFlag(CountryEnum $country, string $type): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}", '.png');

        $fileName = Str::title($country->value) . "-soccer-shield" . $extension;
        return asset($basePath . $fileName);
    }

    public static function getWorldCupBall(CountryEnum $country, string $type): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}", '.png');

        $fileName = Str::title($country->value) . "-soccer-shield" . $extension;
        return asset($basePath . $fileName);
    }

    public static function getWorldCupFifaLogo(CountryEnum $country, string $type): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}", '.png');

        $fileName = Str::title($country->value) . "-soccer-shield" . $extension;
        return asset($basePath . $fileName);
    }

    public static function getWorldCupPoster(CountryEnum $country, string $type): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}", '.png');

        $fileName = Str::title($country->value) . "-soccer-shield" . $extension;
        return asset($basePath . $fileName);
    }
}
