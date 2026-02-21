<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Enums\WorldCupEnum;

use App\Providers\AssetPathProvider;

use App\Enums\BadgeTypeEnum;
use App\Enums\CountryEnum;
use App\Models\Badge;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Los Badges pueden ser balones, los logos, poster, escudos y banderas
        $balls = $this->getAllBalls();
        $logos = $this->getAllLogos();
        $posters = $this->getAllPosters();
        $shields = $this->getAllShields();
        $flags = $this->getAllFlags();

        $badges = array_merge($balls, $logos, $posters, $shields, $flags);

        foreach ($badges as $badge) {
            Badge::updateOrCreate(
                ['code' => $badge['code']],
                [
                    'title' => $badge['title'],
                    'image_url' => $badge['image_url'],
                    'type' => $badge['type'],
                    'description' => $badge['description']
                ]
            );
        }
    }

    private function getAllBalls()
    {
        $worldCups = WorldCupEnum::cases();
        $balls = [];

        foreach ($worldCups as $worldCup) {
            $balls[] = [
                'title' => "Balón del mundial de {$worldCup->value}",
                'code' => "ball_{$worldCup->value}",
                'image_url' => AssetPathProvider::getWorldCupBall($worldCup, 'ball'),
                'type' => BadgeTypeEnum::BALL->value,
                'description' => "El balón oficial utilizado en la Copa del Mundo de {$worldCup->value}."
            ];
        }

        return $balls;
    }

    private function getAllLogos()
    {
        $worldCups = WorldCupEnum::cases();
        $logos = [];

        foreach ($worldCups as $worldCup) {
            $logos[] = [
                'title' => "Logo del mundial de {$worldCup->value}",
                'code' => "logo_{$worldCup->value}",
                'image_url' => AssetPathProvider::getWorldCupBall($worldCup, 'fifa_logo'),
                'type' => BadgeTypeEnum::FIFA_LOGO->value,
                'description' => "El logo oficial de la Copa del Mundo de {$worldCup->value}."
            ];
        }

        return $logos;
    }

    private function getAllPosters()
    {
        $worldCups = WorldCupEnum::cases();
        $posters = [];

        foreach ($worldCups as $worldCup) {
            $posters[] = [
                'title' => "Poster del mundial de {$worldCup->value}",
                'code' => "poster_{$worldCup->value}",
                'image_url' => AssetPathProvider::getWorldCupPoster($worldCup, 'poster'),
                'type' => BadgeTypeEnum::POSTER->value,
                'description' => "El poster oficial de la Copa del Mundo de {$worldCup->value}."
            ];
        }

        return $posters;
    }

    private function getAllShields()
    {
        $countries = CountryEnum::cases();
        $shields = [];

        foreach ($countries as $country) {
            $shields[] = [
                'title' => "Escudo de la seleccion de {$country->value}",
                'code' => "shield_{$country->value}",
                'image_url' => AssetPathProvider::getCountryShield($country, 'shield'),
                'type' => BadgeTypeEnum::SHIELD->value,
                'description' => "El escudo oficial de la seleccion nacional de {$country->value}."
            ];
        }

        return $shields;
    }

    private function getAllFlags()
    {
        $countries = CountryEnum::cases();
        $posters = [];

        foreach ($countries as $country) {
            $posters[] = [
                'title' => "Bandera de la seleccion de {$country->value}",
                'code' => "flag_{$country->value}",
                'image_url' => AssetPathProvider::getCountryFlag($country, 'flag'),
                'type' => BadgeTypeEnum::FLAG->value,
                'description' => "La bandera oficial de {$country->value}."
            ];
        }

        return $posters;
    }
}
