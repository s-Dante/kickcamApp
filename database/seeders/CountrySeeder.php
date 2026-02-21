<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


use App\Models\Country;

use App\Enums\CountryEnum;

use App\Providers\AssetPathProvider;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(AssetPathProvider $assetProvider): void
    {
        $jsonPath = public_path('assets/country_state_city-data/countries.json');

        if (!File::exists($jsonPath)) {
            $this->command->error("Archivo no encontrado");
            return;
        }

        $countriesData = json_decode(File::get($jsonPath), true);

        foreach ($countriesData as $data) {
            $iso2 = strtolower($data['iso2']);

            $countryEnum = CountryEnum::tryFrom($iso2);

            if ($countryEnum) {
                Country::updateOrCreate(
                    ['slug' => $iso2],
                    [
                        'name' => $data['name'],
                        'flag_url' => $assetProvider->getCountryFlag($countryEnum, 'flag'),
                        'ar_target_url' => "assets/targets-ar/{$iso2}.mind"
                    ]
                );
            }
        }
        $this->command->info('Tabla de países poblada con éxito.');
    }
}
