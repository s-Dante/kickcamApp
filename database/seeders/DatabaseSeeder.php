<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Multimedia;
use App\Models\User;

use Database\Seeders\CountrySeeder;
use Database\Seeders\MultimediaSeeder;
use Database\Seeders\UserSeeder; 
use Database\Seeders\BadgeSeeder; 
use Database\Seeders\UserCustomizationSeeder;
use Database\Seeders\QuestionSeeder;
use Database\Seeders\AnswerSeeder;

use App\Providers\AssetPathProvider;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            CountrySeeder::class,
            MultimediaSeeder::class,

            UserSeeder::class,
            BadgeSeeder::class,
            UserCustomizationSeeder::class,
            UserBadgeSeeder::class,

            QuestionSeeder::class,
            /*
            AnswerSeeder::class,
            */
        ]);
    }
}
