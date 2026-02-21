<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

use App\Models\Country;
use App\Models\Multimedia;

use App\Enums\MultimediaCategoryEnum;

class MultimediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $basePath = public_path('assets/multimedia');

        if (!File::exists($basePath)) {
            File::makeDirectory($basePath);
            $this->command->warn("La carpeta {$basePath} no existia y se creo");
            return;
        }

        $countries = Country::all();

        foreach ($countries as $country) {
            $countryPath = "{$basePath}/{$country->slug}";

            if (File::isDirectory($countryPath)){
                $files = File::files($countryPath);

                foreach ($files as $file) {
                    $extension = $file->getExtension();
                    $category = $this->determineCategory($extension);

                    Multimedia::updateorCreate(
                        ['file_url' => "assets/multimedia/{$country->slug}/" . $file->getFilename()],
                        [
                            'category' => $category,
                            'country_id' => $country->id
                        ]
                    );
                }
            }
        }
    }

    private function determineCategory(string $extension): MultimediaCategoryEnum
    {
        return match ($extension) {
            'jpg', 'jpeg', 'png', 'webp' => MultimediaCategoryEnum::IMAGE,
            'mp4', 'mov', 'avi' => MultimediaCategoryEnum::VIDEO,
            'glb', 'obj', 'glt' => MultimediaCategoryEnum::AR,
            default => null,
        };
    }
}
