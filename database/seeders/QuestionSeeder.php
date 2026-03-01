<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use App\Models\Answer;
use App\Models\Country;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = public_path('trivia/trivia.json');

        if (!File::exists($jsonPath)) {
            $this->command->error("File not found at: $jsonPath");
            return;
        }

        $jsonContent = File::get($jsonPath);
        $data = json_decode($jsonContent, true);

        if (!$data) {
            $this->command->error("Invalid JSON format.");
            return;
        }

        $questionsData = array_filter($data, fn($item) => isset($item['question']));
        $answerKeysData = array_filter($data, fn($item) => isset($item['isCorrect']));

        $validityMap = [];
        foreach ($answerKeysData as $keyItem) {
            $validityMap[$keyItem['id']] = $keyItem['isCorrect'];
        }

        DB::transaction(function () use ($questionsData, $validityMap) {
            foreach ($questionsData as $qData) {
                $country = Country::where('slug', $qData['country'])->first();

                if (!$country) {
                    continue;
                }

                $question = Question::create([
                    'question_text' => $qData['question'],
                    'difficulty' => $qData['difficulty'],
                    'country_id' => $country->id,
                ]);

                foreach ($qData['options'] as $option) {
                    $optionId = $option['id'];

                    // Supports both flat map references or direct object booleans
                    $isCorrect = $option['isCorrect'] ?? $option['is_correct'] ?? $validityMap[$optionId] ?? false;

                    Answer::create([
                        'answer_text' => $option['text'],
                        'is_correct' => $isCorrect,
                        'question_id' => $question->id,
                    ]);
                }
            }
        });

        $this->command->info('Trivia imported successfully!');
    }
}
