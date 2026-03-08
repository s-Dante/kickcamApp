<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\View\View;

class MultimediaController extends Controller
{
    /**
     * Display a listing of the available countries for multimedia.
     */
    public function index(): View
    {
        $countries = collect();

        if (class_exists(Country::class)) {
            // Include only countries with multimedia and their counts
            $countries = Country::has('multimedia')->withCount('multimedia')->get();
        }

        $cached = \Illuminate\Support\Facades\Cache::get('world_data_json_light_v2') ?? [];
        $translations = collect($cached)->mapWithKeys(function ($item) {
            $iso2 = isset($item['iso2']) ? strtolower($item['iso2']) : null;
            if (! $iso2) {
                return [];
            }
            $translationsArr = $item['translations'] ?? [];
            $translationsArr['en'] = $item['name'] ?? null;

            return [$iso2 => $translationsArr];
        })->toArray();

        return view('multimedia.index', compact('countries', 'translations'));
    }

    /**
     * Display the multimedia viewer for a specific country.
     */
    public function show(string $slug): View
    {
        $country = Country::with('multimedia')->where('slug', $slug)->firstOrFail();

        return view('multimedia.show', compact('country'));
    }
}
