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

        $liveEvents = $this->sportsService->getLiveEvents($leagueId);
        $pastEvents = $this->sportsService->getPastEvents($leagueId);
        $nextEvents = $this->sportsService->getNextEvents($leagueId);

        $activeLeague = $this->supportedLeagues[$leagueId];
        $leagues = $this->supportedLeagues;

        return view('scoreboard.index', compact('liveEvents', 'pastEvents', 'nextEvents', 'activeLeague', 'leagues'));
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

    /**
     * API request for the AR Camera (Returns Team JSON by ISO Code)
     */
    public function getTeamByIso(string $iso)
    {
        // ISO-alpha-2 to TheSportsDB ID Mapping for World Cup Teams + Historical Cups
        $isoDict = [
            'ar' => ['id' => '133602', 'trophies' => 3], // Argentina
            'mx' => ['id' => '137682', 'trophies' => 0], // Mexico
            'br' => ['id' => '133604', 'trophies' => 5], // Brazil
            'es' => ['id' => '133614', 'trophies' => 1], // Spain
            'fr' => ['id' => '133610', 'trophies' => 2], // France
            'de' => ['id' => '133606', 'trophies' => 4], // Germany
            'gb-eng' => ['id' => '133608', 'trophies' => 1], // England
            'us' => ['id' => '137684', 'trophies' => 0], // USA
            'ca' => ['id' => '137691', 'trophies' => 0], // Canada
            'jp' => ['id' => '135905', 'trophies' => 0], // Japan
        ];

        $teamData = $isoDict[strtolower($iso)] ?? null;

        if (!$teamData) {
            return response()->json(['error' => 'Equipo no mapeado aún'], 404);
        }

        $team = $this->sportsService->getTeamDetails($teamData['id']);

        if (!$team) {
            return response()->json(['error' => 'Error al contactar con TheSportsDB'], 500);
        }

        return response()->json([
            'id' => $team['idTeam'],
            'name' => $team['strTeam'],
            'alternate' => $team['strTeamAlternate'] ?? '',
            'stadium' => $team['strStadium'],
            'formed' => $team['intFormedYear'],
            'website' => $team['strWebsite'],
            'description' => $team['strDescriptionES'] ?? $team['strDescriptionEN'] ?? '',
            'badge' => $team['strBadge'],
            'trophies' => $teamData['trophies']
        ]);
    }
}
