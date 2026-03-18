<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CountryController extends Controller
{
    /**
     * Display a listing of countries.
     */
    public function index(Request $request)
    {
        $countriesPath = public_path('assets/country_state_city-data/countries.json');
        if (! File::exists($countriesPath)) {
            abort(404, 'Countries data not found.');
        }

        $allCountries = collect(json_decode(File::get($countriesPath), true));
        $lang = $request->query('lang', config('app.locale', 'es'));

        // Smart Search: handle accents and multi-field search
        if ($request->filled('search')) {
            $search = Str::lower(Str::ascii($request->get('search')));
            $allCountries = $allCountries->filter(function ($c) use ($search) {
                // Check name (normalized)
                if (Str::contains(Str::lower(Str::ascii($c['name'] ?? '')), $search)) {
                    return true;
                }
                // Check ISOs
                if (Str::contains(Str::lower($c['iso2'] ?? ''), $search)) {
                    return true;
                }
                if (Str::contains(Str::lower($c['iso3'] ?? ''), $search)) {
                    return true;
                }
                // Check translations
                if (isset($c['translations']) && is_array($c['translations'])) {
                    foreach ($c['translations'] as $t) {
                        if (Str::contains(Str::lower(Str::ascii($t ?? '')), $search)) {
                            return true;
                        }
                    }
                }

                return false;
            });
        }

        // Map to objects compatible with country-card.blade.php
        $formattedCountries = $allCountries->map(function ($c) use ($lang) {
            $displayName = $c['translations'][$lang] ?? $c['name'];

            return (object) [
                'id' => $c['id'],
                'name' => $displayName,
                'slug' => strtolower($c['iso2']), // Use ISO as slug for URL
                'iso2' => $c['iso2'],
                'iso3' => $c['iso3'],
                'emoji' => $c['emoji'],
                'flag_url' => asset('assets/country-flags/'.strtolower($c['iso2']).'.svg'),
            ];
        });

        // Pagination
        $perPage = 20;
        $page = (int) $request->get('page', 1);
        $offset = ($page * $perPage) - $perPage;

        $currentPageItems = $formattedCountries->slice($offset, $perPage)->values();

        // Prepare translations map for AlpineJS (only for current page to save memory/bandwidth)
        $translationsMap = [];
        foreach ($currentPageItems as $item) {
            // Find raw data for translations
            $raw = $allCountries->firstWhere('iso2', $item->iso2);
            $translationsMap[$item->slug] = $raw['translations'] ?? [];
        }

        $paginatedItems = new LengthAwarePaginator(
            $currentPageItems,
            $formattedCountries->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('countries.index', [
            'countries' => $paginatedItems,
            'translations' => $translationsMap,
            'lang' => $lang,
        ]);
    }

    /**
     * Display the specified country.
     */
    public function show(Request $request, $iso)
    {
        $countriesPath = public_path('assets/country_state_city-data/countries.json');
        if (! File::exists($countriesPath)) {
            abort(404, 'Countries data not found.');
        }

        $allCountries = collect(json_decode(File::get($countriesPath), true));
        $lang = $request->query('lang', config('app.locale', 'es'));

        $countryData = $allCountries->first(function ($c) use ($iso) {
            return strtolower($c['iso2'] ?? '') === strtolower($iso) || strtolower($c['iso3'] ?? '') === strtolower($iso);
        });

        if (! $countryData) {
            abort(404);
        }

        // Prepare for view
        $country = (object) $countryData;
        $country->displayName = $countryData['translations'][$lang] ?? $countryData['name'];
        $country->flag_url = asset('assets/country-flags/'.strtolower($country->iso2).'.svg');

        // Load states from a separate file to save memory (merging only if needed)
        $statesPath = public_path('assets/country_state_city-data/countries+states.json');
        if (File::exists($statesPath)) {
            $statesData = json_decode(File::get($statesPath), true);
            $countryWithStates = collect($statesData)->firstWhere('name', $countryData['name']);
            $country->states = $countryWithStates['states'] ?? [];
        } else {
            $country->states = [];
        }

        // Try to find silhouette points for audit
        $points = null;
        $namesPath = public_path('data/silhouettes-names.json');
        if (File::exists($namesPath)) {
            $namesData = collect(json_decode(File::get($namesPath), true));
            $silhouette = $namesData->first(function ($s) use ($country) {
                if (isset($s['iso2']) && strtolower($s['iso2']) === strtolower($country->iso2)) {
                    return true;
                }
                if (isset($s['iso3']) && strtolower($s['iso3']) === strtolower($country->iso3)) {
                    return true;
                }

                return strtolower($s['name']) === strtolower($country->name);
            });
            if ($silhouette) {
                $points = $silhouette['points'] ?? null;
            }
        }

        return view('countries.show', compact('country', 'points', 'lang'));
    }
}
