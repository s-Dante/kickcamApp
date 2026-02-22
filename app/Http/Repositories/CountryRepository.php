<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Collection;

use App\Models\Country;
use App\Models\Question;

class CountryRepository
{

    public function getAllCountries(): Collection
    {
        return Country::all(['id', 'name', 'flag_url', 'slug']);
    }

    public function getCountryWithMultimedia(string $slug): ?Country
    {
        return Country::where('slug', $slug)->with('multimedia')->first();
    }

    public function getCountryBySlug(string $slug): ?Country
    {
        return Country::where('slug', $slug)->first();
    }

    public function getQuestionsByCountry(int $countryId): Collection
    {
        return Question::where('country_id', $countryId)
            ->with('answer')
            ->get();
    }
}
