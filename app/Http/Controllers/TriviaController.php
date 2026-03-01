<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Services\TriviaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TriviaController extends Controller
{
    /**
     * Display a listing of the available trivias.
     */
    public function index(): View
    {
        // For Phase 1.5, we will load countries that have questions configured
        // Currently bypassing the 'has questions' filter since DB might be empty,
        // just loading all available countries or an empty collection.

        $countries = collect(); // Placeholder for actual App\Models\Country::all() or similar

        if (class_exists(Country::class)) {
            // In a real scenario, you'd want: Country::has('questions')->withCount('questions')->get();
            // $countries = Country::all();
        }

        return view('trivia.index', compact('countries'));
    }

    /**
     * Load the Trivia Quiz for a specific context.
     */
    public function play(string $slug, TriviaService $triviaService): View|RedirectResponse
    {
        $questions = [];
        $type = 'country'; // default

        // Handle World Global Challenge
        if ($slug === 'world') {
            $questions = $triviaService->generateWorldTrivia(5);
            $type = 'world';
        } else {
            // Handle Country Specific Database Questions
            // $country = Country::with('questions')->findOrFail($slug);
            // $questions = $country->questions()->inRandomOrder()->take(5)->get();

            // To prevent failures while DB is technically empty for now during dev
            return redirect()->route('trivia.index')->with('error', 'El país seleccionado no tiene preguntas cargadas aún.');
        }

        return view('trivia.play', compact('questions', 'type', 'slug'));
    }

    /**
     * Evaluate the submitted answers and attribute points.
     */
    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|string',
            'answers.*.user_answer' => 'required|string',
            'answers.*.correct_answer' => 'required|string',
            'trivia_type' => 'required|string',
        ]);

        $score = 0;
        $totalEarnedPoints = 0;
        $totalQuestions = count($validated['answers']);

        foreach ($validated['answers'] as $ans) {
            $decryptedCorrect = decrypt($ans['correct_answer']);

            if (trim(strtolower($ans['user_answer'])) === trim(strtolower($decryptedCorrect))) {
                $score++;
                $totalEarnedPoints += 10; // For now all questions yield 10pts
            }
        }

        // Apply Points to the User
        if ($totalEarnedPoints > 0) {
            $user = auth()->user();
            $user->points = ($user->points ?? 0) + $totalEarnedPoints;
            $user->save();
        }

        // Redirect back with success message showing the Score vs Total
        return redirect()->route('trivia.index')->with('status', "¡Completado! Acertaste {$score} de {$totalQuestions}. Acabas de ganar +{$totalEarnedPoints} puntos.");
    }
}
