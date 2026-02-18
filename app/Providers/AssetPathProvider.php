<?php

namespace App\Providers;

use App\Enums\CountryEnum;
use Illuminate\Support\Str;

class AssetPathService
{
    public static function get3DModel(CountryEnum $country, string $type): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}");

        $fileName = Str::title($country->value) . $extension;
        return asset($basePath . $fileName);
    }
    
    public static function getCountryFlag(CountryEnum $country, string $type): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}", '.png');

        $fileName = Str::title($country->value) . $extension;
        return asset($basePath . $fileName);
    }

    public static function getCountryShield(CountryEnum $country, string $type): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}");

        $fileName = Str::title($country->value) . "-soccer-shield" . $extension;
        return asset($basePath . $fileName);
    }

    public static function getFaceTrackingFilter(CountryEnum $country, string $type): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}");

        $fileName = Str::title($country->value) . $extension;
        return asset($basePath . $fileName);
    }

    public static function getTargetAR(CountryEnum $country, string $type): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}");

        $fileName = Str::title($country->value) . $extension;
        return asset($basePath . $fileName);
    }

    public static function getWorldCupBall(CountryEnum $country, string $type, string $year): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}", '.png');

        $fileName = $year . "-" . Str::title($country->value) . $extension;
        return asset($basePath . $fileName);
    }

    public static function getWorldCupFifaLogo(string $type, string $year): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}", '.png');

        $fileName = "wordl-cup-" . $year . "-logo" . $extension;
        return asset($basePath . $fileName);
    }

    public static function getWorldCupPoster(CountryEnum $country, string $type, string $year): string
    {
        $basePath = config("assets.paths.{$type}");
        $extension = config("assets.extensions.{$type}", '.png');

        $fileName = $year . "-" . Str::title($country->value) . $extension;
        return asset($basePath . $fileName);
    }
}
