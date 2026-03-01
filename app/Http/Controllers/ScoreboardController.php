<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\TheSportsDbService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScoreboardController extends Controller
{
    private array $supportedLeagues = [
        TheSportsDbService::LEAGUE_MX => [
            'id' => TheSportsDbService::LEAGUE_MX,
            'name' => 'Liga MX',
            'icon' => '🇲🇽'
        ],
        TheSportsDbService::LEAGUE_LALIGA => [
            'id' => TheSportsDbService::LEAGUE_LALIGA,
            'name' => 'La Liga',
            'icon' => '🇪🇸'
        ],
        TheSportsDbService::LEAGUE_PREMIER => [
            'id' => TheSportsDbService::LEAGUE_PREMIER,
            'name' => 'Premier League',
            'icon' => '🏴󠁧󠁢󠁥󠁮󠁧󠁿'
        ],
        TheSportsDbService::LEAGUE_WORLD_CUP => [
            'id' => TheSportsDbService::LEAGUE_WORLD_CUP,
            'name' => 'Mundial 2026',
            'icon' => '🏆'
        ],
    ];

    public function __construct(
        private readonly TheSportsDbService $sportsService
    ) {
    }

    /**
     * Display the scoreboard feed for a given league (or default).
     */
    public function index(Request $request): View
    {
        // Default to Liga MX if no league parameter is passed or if invalid
        $leagueId = $request->query('league', TheSportsDbService::LEAGUE_MX);

        if (!array_key_exists($leagueId, $this->supportedLeagues)) {
            $leagueId = TheSportsDbService::LEAGUE_MX;
        }

        $pastEvents = $this->sportsService->getPastEvents($leagueId);
        $nextEvents = $this->sportsService->getNextEvents($leagueId);

        $activeLeague = $this->supportedLeagues[$leagueId];
        $leagues = $this->supportedLeagues;

        return view('scoreboard.index', compact('pastEvents', 'nextEvents', 'activeLeague', 'leagues'));
    }

    /**
     * Display the profile and last matches for a specific team/selection.
     */
    public function showTeam(string $id): View
    {
        $team = $this->sportsService->getTeamDetails($id);

        if (!$team) {
            abort(404, 'No se encontró la información del equipo.');
        }

        $lastEvents = $this->sportsService->getTeamLastEvents($id);

        return view('scoreboard.team', compact('team', 'lastEvents'));
    }
}
