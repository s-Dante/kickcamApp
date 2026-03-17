<?php

namespace App\Http\Controllers;

use App\Models\Badge;
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
        $countries = collect();

        if (class_exists(Country::class)) {
            $countries = Country::has('question')->withCount('question')->get();
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

        return view('trivia.index', compact('countries', 'translations'));
    }

    /**
     * Load the Trivia Quiz for a specific context.
     */
    public function play(Request $request, TriviaService $triviaService, string $slug): View|RedirectResponse
    {
        $questions = [];
        $type = 'country'; // default

        $lang = $request->query('lang', 'es');

        // Handle World Global Challenge
        if ($slug === 'world') {
            $questions = $triviaService->generateWorldTrivia(5, $lang);
            $type = 'world';
            $triviaType = 'world';
            $title = 'Desafío Mundial';
        } elseif ($slug === 'flags') {
            $questions = $triviaService->generateFlagsTrivia(5, $lang);
            $type = 'flags';
            $triviaType = 'flags';
            $title = 'Desafío Banderas';
        } elseif ($slug === 'shields') {
            $questions = $triviaService->generateShieldsTrivia(5, $lang);
            $triviaType = 'shields';
            $title = 'Desafío Escudos';
        } elseif ($slug === 'languages') {
            $questions = $triviaService->generateLanguageTrivia(5, $lang);
            $triviaType = 'languages';
            $title = 'Desafío Idiomas';
        } else {
            // Handle Country Specific Database Questions
            // Eager load everything needed for the DB match format
            $country = Country::with('question.answer')->findOrFail($slug);

            // To preserve eager loaded relationships, we access the collection property directly
            // and use collection methods rather than query builder methods.
            $dbQuestions = $country->question;

            if ($dbQuestions->isEmpty()) {
                return redirect()->route('trivia.index')->with('error', 'El país seleccionado no tiene preguntas cargadas aún.');
            }

            // Randomize and take up to 5
            $dbQuestions = $dbQuestions->shuffle()->take(5);

            foreach ($dbQuestions as $q) {
                // Ensure there is at least a correct answer
                $correct = $q->answer->where('is_correct', true)->first();
                if (! $correct) {
                    continue;
                }

                $options = $q->answer->pluck('answer_text')->shuffle()->toArray();

                $points = match ($q->difficulty) {
                    \App\Enums\QuestionDifficultyEnum::EASY => 5,
                    \App\Enums\QuestionDifficultyEnum::MEDIUM => 10,
                    \App\Enums\QuestionDifficultyEnum::HARD => 15,
                    default => 10,
                };

                $questions[] = [
                    'id' => 'q_db_'.$q->id,
                    'question' => $q->question_text,
                    'options' => $options,
                    'correct_answer' => $correct->answer_text,
                    'points' => $points,
                    'type' => 'db_country',
                ];
            }
        }

        return view('trivia.play', compact('questions', 'type', 'slug'));
    }

    /**
     * Load the Silhouette game mode.
     */
    public function playSilhouette(Request $request, TriviaService $triviaService): View|RedirectResponse
    {
        $lang = $request->query('lang', config('app.locale', 'es'));

        $questions = $triviaService->generateSilhouetteTrivia(5, $lang);

        if (empty($questions)) {
            // Check if the file exists to give a better error message
            if (! file_exists(public_path('data/silhouettes-names.json'))) {
                return redirect()->route('trivia.index')->with('error', 'El archivo principal de siluetas no existe. Ve a /trivia/compilador-siluetas para generarlo primero.');
            }

            return redirect()->route('trivia.index')->with('error', 'No hay suficientes siluetas para jugar o hubo un problema al cargar los datos.');
        }

        $type = 'silhouette';
        $slug = 'siluetas';

        return view('trivia.silhouette', compact('questions', 'type', 'slug', 'lang'));
    }

    /**
     * Evaluate the submitted answers and attribute points.
     */
    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|string',
            'answers.*.question_text' => 'required|string',
            'answers.*.user_answer' => 'required|string',
            'answers.*.correct_answer' => 'required|string',
            'answers.*.points' => 'required|string',
            'answers.*.image' => 'nullable|string',
            'trivia_type' => 'required|string',
        ]);

        $score = 0;
        $totalEarnedPoints = 0;
        $totalQuestions = count($validated['answers']);
        $detailedResults = [];

        foreach ($validated['answers'] as $ans) {
            $decryptedCorrect = decrypt($ans['correct_answer']);
            $decryptedQuestion = decrypt($ans['question_text']);

            $isCorrect = trim(strtolower($ans['user_answer'])) === trim(strtolower($decryptedCorrect));

            if ($isCorrect) {
                $score++;
                $pts = (int) decrypt($ans['points']);
                $totalEarnedPoints += $pts;
            }

            $detailedResults[] = [
                'question' => $decryptedQuestion,
                'user_answer' => $ans['user_answer'],
                'correct_answer' => $decryptedCorrect,
                'is_correct' => $isCorrect,
                'image' => isset($ans['image']) ? decrypt($ans['image']) : null,
            ];
        }

        $user = auth()->user();
        $awardedItems = [];

        // Apply Points to the User
        if ($totalEarnedPoints > 0) {
            $user->points = ($user->points ?? 0) + $totalEarnedPoints;
            $user->save();
        }

        // Logic 1: General Achievement - "Primera Trivia Jugada"
        $firstTriviaBadge = Badge::where('code', 'general_trivia_primera')->first();
        if ($firstTriviaBadge && ! $user->badges()->where('badges.id', $firstTriviaBadge->id)->exists()) {
            $user->badges()->syncWithoutDetaching([$firstTriviaBadge->id => ['earned_at' => now()]]);
            $awardedItems[] = 'Logro: Primera Trivia';
        }

        // Logic 2: Reward AR Badge based on performance (e.g. perfect score = 100% chance, 80% = random chance)
        // For development we will award one purely randomly if they score > 0
        if ($score > 0) {
            $soccerBadge = Badge::where('sport_category', 'soccer')->inRandomOrder()->first();
            if ($soccerBadge && ! $user->badges()->where('badges.id', $soccerBadge->id)->exists()) {
                $user->badges()->syncWithoutDetaching([$soccerBadge->id => ['earned_at' => now()]]);
                $awardedItems[] = "Colección: {$soccerBadge->title}";
            }
        }

        // Redirect back to detailed Results Page with flashed data
        return redirect()->route('trivia.results')->with([
            'status' => '¡Trivia Completada!',
            'score' => $score,
            'totalQuestions' => $totalQuestions,
            'totalEarnedPoints' => $totalEarnedPoints,
            'awardedItems' => $awardedItems,
            'detailedResults' => $detailedResults,
        ]);
    }

    /**
     * Show detailed results after a Trivia session.
     */
    public function results(): View|RedirectResponse
    {
        // Guard if accessed directly without session data
        if (! session()->has('detailedResults')) {
            return redirect()->route('trivia.index');
        }

        return view('trivia.results');
    }
}
