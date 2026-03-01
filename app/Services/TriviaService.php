<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class TriviaService
{
    /**
     * Path to the local JSON file containing world data.
     */
    protected string $jsonPath = 'assets/country_state_city-data/countries+states+cities.json';

    /**
     * Generate random questions from the local JSON file.
     * We cache the decoded JSON array to prevent parsing a large file repeatedly.
     *
     * @param  int  $amount  Number of questions to generate
     */
    public function generateWorldTrivia(int $amount = 5): array
    {
        // Increase memory limit for this specific deep parsing if necessary in CLI/Test modes
        ini_set('memory_limit', '512M');

        $countries = Cache::remember('world_data_json_light', 3600, function () {
            $path = public_path($this->jsonPath);
            if (! File::exists($path)) {
                return [];
            }

            // The pure file is huge due to 'states' and 'cities'. We will filter
            // those out before caching to drastically save RAM memory going forward.
            $raw = json_decode(File::get($path), true);
            if (! is_array($raw)) {
                return [];
            }

            return array_map(function ($country) {
                return [
                    'name' => $country['name'] ?? null,
                    'capital' => $country['capital'] ?? null,
                    'currency_name' => $country['currency_name'] ?? null,
                    'region' => $country['region'] ?? null,
                    'subregion' => $country['subregion'] ?? null,
                ];
            }, $raw);
        });

        if (empty($countries)) {
            return [];
        }

        $questions = [];
        $countriesCollection = collect($countries);

        // Define question templates based on JSON structure
        $questionTypes = [
            'capital' => '¿Cuál es la capital de :country?',
            'currency' => '¿Cuál es la moneda oficial de :country?',
            'region' => '¿En qué continente/región se encuentra :country?',
            'subregion' => '¿A qué subregión geográfica pertenece :country?',
        ];

        for ($i = 0; $i < $amount; $i++) {
            // 1. Pick a random country for the question
            $targetCountry = $countriesCollection->random();
            if (empty($targetCountry['name'])) {
                continue;
            }

            // 2. Pick a random question type
            $type = array_rand($questionTypes);
            $questionText = str_replace(':country', $targetCountry['name'], $questionTypes[$type]);

            // 3. Determine the correct answer based on the type
            $correctAnswer = $this->getAnswerForType($targetCountry, $type);

            // Sometimes the parameter might be empty in the JSON, fallback to another try
            if (empty($correctAnswer)) {
                $i--; // Retry this iteration

                continue;
            }

            // 4. Generate 3 wrong answers by picking random countries
            $wrongCountries = $countriesCollection->where('name', '!=', $targetCountry['name'])->random(3);
            $wrongAnswers = [];
            foreach ($wrongCountries as $wrong) {
                $wrongAns = $this->getAnswerForType($wrong, $type);
                // Avoid duplicates visually
                if (! empty($wrongAns) && $wrongAns !== $correctAnswer && ! in_array($wrongAns, $wrongAnswers)) {
                    $wrongAnswers[] = $wrongAns;
                }
            }

            // Fill missing wrong answers if duplicates were skipped
            while (count($wrongAnswers) < 3) {
                // Fallback generic wrong strings just in case
                $wrongAnswers[] = 'N/A';
            }

            // 5. Structure the final payload
            $options = array_merge([$correctAnswer], $wrongAnswers);
            shuffle($options);

            $questions[] = [
                'id' => 'q_world_'.uniqid(),
                'question' => $questionText,
                'options' => $options,
                'correct_answer' => $correctAnswer,
                'points' => 10, // Default points for world questions
                'type' => 'json_world',
            ];
        }

        return $questions;
    }

    /**
     * Map the generic question type to the json index.
     */
    private function getAnswerForType(array $countryData, string $type): ?string
    {
        return match ($type) {
            'capital' => $countryData['capital'] ?? null,
            'currency' => $countryData['currency_name'] ?? null,
            'region' => $countryData['region'] ?? null,
            'subregion' => $countryData['subregion'] ?? null,
            default => null,
        };
    }
}
