<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
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
            // Include count of multimedia items if relationship exists
            $countries = Country::withCount('multimedia')->get();
        }

        return view('multimedia.index', compact('countries'));
    }

    /**
     * Display the multimedia viewer for a specific country.
     */
    public function show(string $slug): View
    {
        $country = Country::with('multimedia')->findOrFail($slug);

        return view('multimedia.show', compact('country'));
    }
}
