<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\UserCustomization;
use App\Models\User;

class UserCustomizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            if(!$user->customization) {
                UserCustomization::factory()->create([
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
