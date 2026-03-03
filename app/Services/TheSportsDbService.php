<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TheSportsDbService
{
    private string $baseUrl;

    public function __construct()
    {
        $apiKey = config('services.sportsdb.key', '3');
        $this->baseUrl = "https://www.thesportsdb.com/api/v1/json/{$apiKey}";
    }


    // Some popular league IDs for the free tier
    public const LEAGUE_MX = '4350';
    public const LEAGUE_PREMIER = '4328';
    public const LEAGUE_LALIGA = '4335';
    public const LEAGUE_WORLD_CUP = '4429'; // Note: FIFA World Cup or International Placeholder

    /**
     * Get the latest 15 past events for a specific league.
     * Caches the result for 2 hours to prevent API rate limiting.
     *
     * @param string $leagueId
     * @return array
     */
    public function getPastEvents(string $leagueId): array
    {
        $cacheKey = "sportsdb_past_events_{$leagueId}";

        return Cache::remember($cacheKey, now()->addHours(2), function () use ($leagueId) {
            try {
                $response = Http::timeout(10)->get($this->baseUrl . '/eventspastleague.php', [
                    'id' => $leagueId,
                ]);

                if ($response->successful()) {
                    return $response->json('events') ?? [];
                }

                Log::warning("TheSportsDB API request failed for past events", [
                    'league_id' => $leagueId,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            } catch (\Exception $e) {
                Log::error("Exception in TheSportsDbService@getPastEvents: " . $e->getMessage());
            }

            return []; // Return empty array on failure
        });
    }

    /**
     * Get live/today's events for a specific league.
     * Caches the result very briefly (2 minutes) since it's live data.
     * Uses the eventsday endpoint which covers today's matches.
     *
     * @param string $leagueId
     * @return array
     */
    public function getLiveEvents(string $leagueId): array
    {
        $cacheKey = "sportsdb_live_events_{$leagueId}_" . now()->format('Y-m-d');

        // Short cache of 2 minutes to keep it fresh
        return Cache::remember($cacheKey, now()->addMinutes(2), function () use ($leagueId) {
            try {
                // Determine today's date for params
                $today = now()->format('Y-m-d');

                // Try eventsday.php explicitly for today's matches
                $response = Http::timeout(10)->get($this->baseUrl . '/eventsday.php', [
                    'id' => $leagueId,
                    'd' => $today,
                ]);

                if ($response->successful()) {
                    return $response->json('events') ?? [];
                }

                Log::warning("TheSportsDB API request failed for live/today events", [
                    'league_id' => $leagueId,
                    'status' => $response->status(),
                ]);
            } catch (\Exception $e) {
                Log::error("Exception in TheSportsDbService@getLiveEvents: " . $e->getMessage());
            }

            return [];
        });
    }

    /**
     * Get the next 15 upcoming events for a specific league.
     * Caches the result for 2 hours.
     *
     * @param string $leagueId
     * @return array
     */
    public function getNextEvents(string $leagueId): array
    {
        $cacheKey = "sportsdb_next_events_{$leagueId}";

        return Cache::remember($cacheKey, now()->addHours(2), function () use ($leagueId) {
            try {
                $response = Http::timeout(10)->get($this->baseUrl . '/eventsnextleague.php', [
                    'id' => $leagueId,
                ]);

                if ($response->successful()) {
                    return $response->json('events') ?? [];
                }

                Log::warning("TheSportsDB API request failed for next events", [
                    'league_id' => $leagueId,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            } catch (\Exception $e) {
                Log::error("Exception in TheSportsDbService@getNextEvents: " . $e->getMessage());
            }

            return [];
        });
    }

    /**
     * Get details for a specific team.
     * Caches the result for 24 hours since team info rarely changes.
     *
     * @param string $teamId
     * @return array|null
     */
    public function getTeamDetails(string $teamId): ?array
    {
        $cacheKey = "sportsdb_team_{$teamId}";

        return Cache::remember($cacheKey, now()->addHours(24), function () use ($teamId) {
            try {
                $response = Http::timeout(10)->get($this->baseUrl . '/lookupteam.php', [
                    'id' => $teamId,
                ]);

                if ($response->successful()) {
                    $teams = $response->json('teams');
                    return $teams ? $teams[0] : null;
                }

                Log::warning("TheSportsDB API request failed for team details", [
                    'team_id' => $teamId,
                    'status' => $response->status(),
                ]);
            } catch (\Exception $e) {
                Log::error("Exception in TheSportsDbService@getTeamDetails: " . $e->getMessage());
            }

            return null;
        });
    }

    /**
     * Get the last 5 events for a specific team.
     * Caches the result for 2 hours.
     *
     * @param string $teamId
     * @return array
     */
    public function getTeamLastEvents(string $teamId): array
    {
        $cacheKey = "sportsdb_team_last_events_{$teamId}";

        return Cache::remember($cacheKey, now()->addHours(2), function () use ($teamId) {
            try {
                $response = Http::timeout(10)->get($this->baseUrl . '/eventslast.php', [
                    'id' => $teamId,
                ]);

                if ($response->successful()) {
                    return $response->json('results') ?? [];
                }

                Log::warning("TheSportsDB API request failed for team last events", [
                    'team_id' => $teamId,
                    'status' => $response->status(),
                ]);
            } catch (\Exception $e) {
                Log::error("Exception in TheSportsDbService@getTeamLastEvents: " . $e->getMessage());
            }

            return [];
        });
    }
}
