<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\CountryRepository;

class AppContentController extends Controller
{
    protected CountryRepository $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function multimediaIndex()
    {
        $countries = $this->countryRepository->getAllCountries();

        return view('multimedia.index', compact('countries'));
    }

    public function watchMultimedia(string $slug)
    {
        $country = $this->countryRepository->getCountryWithMultimedia($slug);

        if (! $country) {
            abort(404);
        }

        return view('multimedia.watch', compact('country'));
    }

    public function triviaIndex()
    {
        $countries = $this->countryRepository->getAllCountries();

        return view('trivia.index', compact('countries'));
    }

    public function playTrivia(string $slug)
    {
        $country = $this->countryRepository->getCountryBySlug($slug);
        if (! $country) {
            abort(404);
        }

        $questions = $this->countryRepository->getQuestionsByCountry($country->id);

        return view('trivia.trivia', compact('country', 'questions'));
    }
}
