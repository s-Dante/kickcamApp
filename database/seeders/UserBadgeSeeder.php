<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Badge;
use App\Models\UserBadge;

class UserBadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $badges = Badge::all();

        if ($badges->isEmpty()) {
            $this->command->warn("No se encontraron Badges, se omitira la implementaciond e UserBadgeSeeder");
            return;
        }

        foreach ($users as $user) {
            $randomBadges = $badges->random(rand(0,5));
            foreach ($randomBadges as $badge) {
                UserBadge::firstOrCreate([
                    'user_id' => $user->id,
                    'badge_id' => $badge->id,
                ],
                [
                    'earned_at' => now()->subDays(rand(0, 365)),
                ]);
            }
        }
    }
}
