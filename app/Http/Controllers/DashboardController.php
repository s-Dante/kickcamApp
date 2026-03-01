<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Get all Badges locally mapped
        $allBadges = Badge::all();

        // 2. Identify precisely which badge IDs the Authenticated User currently holds
        $userUnlockedIds = $user->badges()->pluck('badges.id')->toArray();

        // 3. Separate Logic for General (Missions) and Soccer (AR Mode) mapping through the Frontend
        $generalBadges = $allBadges->where('sport_category', 'general');

        // Note: For Soccer badges, the user's interface uses types as Categories (flag, shield, ball, fifa_logo, poster)
        $soccerBadges = $allBadges->where('sport_category', 'soccer');
        $soccerCategories = [
            'flag' => $soccerBadges->where('type', 'flag')->values(),
            'shield' => $soccerBadges->where('type', 'shield')->values(),
            'ball' => $soccerBadges->where('type', 'ball')->values(),
            'fifa_logo' => $soccerBadges->where('type', 'fifa_logo')->values(),
            'poster' => $soccerBadges->where('type', 'poster')->values(),
        ];

        return view('dashboard', [
            'userUnlockedIds' => $userUnlockedIds,
            'generalBadges' => $generalBadges,
            'soccerCategories' => $soccerCategories,
        ]);
    }
}
