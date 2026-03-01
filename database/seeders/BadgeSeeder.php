<?php

namespace Database\Seeders;

use App\Enums\BadgeTypeEnum;
use App\Enums\CountryEnum;
use App\Enums\WorldCupEnum;
use App\Models\Badge;
use App\Providers\AssetPathProvider;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Los Badges pueden ser balones, los logos, poster, escudos y banderas
        $generals = $this->getAllGenerals();
        $balls = $this->getAllBalls();
        $logos = $this->getAllLogos();
        $posters = $this->getAllPosters();
        $shields = $this->getAllShields();
        $flags = $this->getAllFlags();

        $badges = array_merge($generals, $balls, $logos, $posters, $shields, $flags);

        foreach ($badges as $badge) {
            Badge::updateOrCreate(
                ['code' => $badge['code']],
                [
                    'title' => $badge['title'],
                    'image_url' => $badge['image_url'],
                    'type' => $badge['type'],
                    'sport_category' => $badge['sport_category'],
                    'description' => $badge['description'],
                ]
            );
        }
    }

    private function getAllGenerals()
    {
        return [
            [
                'title' => 'Primer Registro',
                'code' => 'general_registro',
                'image_url' => '/assets/badges/general/registro.png', // Placeholder
                'type' => BadgeTypeEnum::GENERAL->value,
                'sport_category' => 'general',
                'description' => 'Obtenido por unirte a Kickcam.',
            ],
            [
                'title' => 'Primera Trivia',
                'code' => 'general_trivia_primera',
                'image_url' => '/assets/badges/general/trivia.png',
                'type' => BadgeTypeEnum::GENERAL->value,
                'sport_category' => 'general',
                'description' => 'Tu primer paso hacia el conocimiento.',
            ],
            [
                'title' => 'Primer Scan AR',
                'code' => 'general_ar_primero',
                'image_url' => '/assets/badges/general/ar.png',
                'type' => BadgeTypeEnum::GENERAL->value,
                'sport_category' => 'general',
                'description' => 'Te atreviste a descubrir el mundo en realidad aumentada.',
            ],
            [
                'title' => 'Trivia Master',
                'code' => 'general_trivia_10',
                'image_url' => '/assets/badges/general/trivia_10.png',
                'type' => BadgeTypeEnum::GENERAL->value,
                'sport_category' => 'general',
                'description' => 'Otorgado por jugar y desafiarte al menos 10 veces.',
            ],
        ];
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
                'sport_category' => 'soccer',
                'description' => "El balón oficial utilizado en la Copa del Mundo de {$worldCup->value}.",
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
                'sport_category' => 'soccer',
                'description' => "El logo oficial de la Copa del Mundo de {$worldCup->value}.",
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
                'sport_category' => 'soccer',
                'description' => "El poster oficial de la Copa del Mundo de {$worldCup->value}.",
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
                'sport_category' => 'soccer',
                'description' => "El escudo oficial de la seleccion nacional de {$country->value}.",
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
                'sport_category' => 'soccer',
                'description' => "La bandera oficial de {$country->value}.",
            ];
        }

        return $posters;
    }
}
