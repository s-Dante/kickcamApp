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
     * @param  string  $lang  Language for the questions ('es', 'en', 'fr', etc.)
     */
    public function generateWorldTrivia(int $amount = 5, string $lang = 'es'): array
    {
        // Increase memory limit for this specific deep parsing if necessary in CLI/Test modes
        ini_set('memory_limit', '512M');

        $countries = Cache::remember('world_data_json_light_v2', 3600, function () {
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
                    'iso2' => $country['iso2'] ?? null,
                    'capital' => $country['capital'] ?? null,
                    'currency_name' => $country['currency_name'] ?? null,
                    'region' => $country['region'] ?? null,
                    'subregion' => $country['subregion'] ?? null,
                    'translations' => [
                        'ko' => $country['translations']['ko'] ?? null,
                        'pt' => $country['translations']['pt'] ?? null,
                        'de' => $country['translations']['de'] ?? null,
                        'es' => $country['translations']['es'] ?? null,
                        'fr' => $country['translations']['fr'] ?? null,
                        'ja' => $country['translations']['ja'] ?? null,
                        'it' => $country['translations']['it'] ?? null,
                        'fa' => $country['translations']['fa'] ?? null,
                        'ru' => $country['translations']['ru'] ?? null,
                        'zh-CN' => $country['translations']['zh-CN'] ?? null,
                    ],
                ];
            }, $raw);
        });

        if (empty($countries)) {
            return [];
        }

        $questions = [];
        $countriesCollection = collect($countries);

        // Define dynamic question templates per language
        $templates = [
            'es' => [
                'capital' => '¿Cuál es la capital de :country?',
                'currency' => '¿Cuál es la moneda oficial de :country?',
                'region' => '¿En qué continente/región se encuentra :country?',
                'subregion' => '¿A qué subregión geográfica pertenece :country?',
                'city' => '¿En qué país se encuentra la ciudad de :entity?',
                'state' => '¿En qué país se ubica el estado/provincia de :entity?',
                'trick' => 'Ninguna de las anteriores',
                'na' => 'N/A',
            ],
            'en' => [
                'capital' => 'What is the capital of :country?',
                'currency' => 'What is the official currency of :country?',
                'region' => 'In which continent/region is :country located?',
                'subregion' => 'To which geographical subregion does :country belong?',
                'city' => 'In which country is the city of :entity located?',
                'state' => 'In which country is the state/province of :entity located?',
                'trick' => 'None of the above',
                'na' => 'N/A',
            ],
            'fr' => [
                'capital' => 'Quelle est la capitale de :country ?',
                'currency' => 'Quelle est la monnaie officielle de :country ?',
                'region' => 'Dans quel continent/région se trouve :country ?',
                'subregion' => 'À quelle sous-région géographique appartient :country ?',
                'city' => 'Dans quel pays se trouve la ville de :entity ?',
                'state' => 'Dans quel pays se trouve l\'état/province de :entity ?',
                'trick' => 'Aucune de ces réponses',
                'na' => 'N/D',
            ],
            'de' => [
                'capital' => 'Was ist die Hauptstadt von :country?',
                'currency' => 'Was ist die offizielle Währung von :country?',
                'region' => 'Auf welchem Kontinent/in welcher Region liegt :country?',
                'subregion' => 'Zu welcher geografischen Subregion gehört :country?',
                'city' => 'In welchem Land liegt die Stadt :entity?',
                'state' => 'In welchem Land liegt der Bundesstaat/die Provinz :entity?',
                'trick' => 'Keine der oben genannten',
                'na' => 'K/A',
            ],
            'it' => [
                'capital' => 'Qual è la capitale di :country?',
                'currency' => 'Qual è la valuta ufficiale di :country?',
                'region' => 'In quale continente/regione si trova :country?',
                'subregion' => 'A quale sottoregione geografica appartiene :country?',
                'city' => 'In quale paese si trova la città di :entity?',
                'state' => 'In quale paese si trova lo stato/provincia di :entity?',
                'trick' => 'Nessuna delle precedenti',
                'na' => 'N/D',
            ],
            'pt' => [
                'capital' => 'Qual é a capital de :country?',
                'currency' => 'Qual é a moeda oficial de :country?',
                'region' => 'Em qual continente/região está localizado(a) :country?',
                'subregion' => 'A qual sub-região geográfica pertence :country?',
                'city' => 'Em qual país está localizada a cidade de :entity?',
                'state' => 'Em qual país está localizado o estado/província de :entity?',
                'trick' => 'Nenhuma das alternativas',
                'na' => 'N/D',
            ],
            'ko' => [
                'capital' => ':country의 수도는 어디입니까?',
                'currency' => ':country의 공식 통화는 무엇입니까?',
                'region' => ':country는 어느 대륙/지역에 있습니까?',
                'subregion' => ':country는 어느 지리적 소지역에 속합니까?',
                'city' => ':entity 도시는 어느 나라에 있습니까?',
                'state' => ':entity 주/도는 어느 나라에 있습니까?',
                'trick' => '해당 없음',
                'na' => '해당 없음',
            ],
            'ja' => [
                'capital' => ':countryの首都はどこですか？',
                'currency' => ':countryの公式通貨は何ですか？',
                'region' => ':countryはどの地域/大陸にありますか？',
                'subregion' => ':countryはどの地理的サブ地域に属していますか？',
                'city' => ':entityという都市はどの国にありますか？',
                'state' => ':entityという州/県はどの国にありますか？',
                'trick' => '上記のどれでもない',
                'na' => '該当なし',
            ],
            'fa' => [
                'capital' => 'پایتخت :country کدام است؟',
                'currency' => 'واحد پول رسمی :country چیست؟',
                'region' => ':country در کدام قاره/منطقه قرار دارد؟',
                'subregion' => ':country به کدام زیرمنطقه جغرافیایی تعلق دارد؟',
                'city' => 'شهر :entity در کدام کشور قرار دارد؟',
                'state' => 'ایالت/استان :entity در کدام کشور قرار دارد؟',
                'trick' => 'هیچکدام از موارد بالا',
                'na' => 'نامشخص',
            ],
            'ru' => [
                'capital' => 'Какая столица у страны :country?',
                'currency' => 'Какая официальная валюта в стране :country?',
                'region' => 'На каком континенте/в каком регионе находится :country?',
                'subregion' => 'К какому географическому субрегиону относится :country?',
                'city' => 'В какой стране находится город :entity?',
                'state' => 'В какой стране находится штат/провинция :entity?',
                'trick' => 'Ни один из вышеперечисленных',
                'na' => 'Н/Д',
            ],
            'zh-CN' => [
                'capital' => ':country 的首都是哪里？',
                'currency' => ':country 的官方货币是什么？',
                'region' => ':country 位于哪个大洲/地区？',
                'subregion' => ':country 属于哪个地理次区域？',
                'city' => ':entity 这座城市位于哪个国家？',
                'state' => ':entity 这个州/省位于哪个国家？',
                'trick' => '以上都不是',
                'na' => '不适用',
            ],
        ];

        // Fallback to spanish if code is unknown
        $questionTypes = $templates[$lang] ?? $templates['es'];
        $trickString = $questionTypes['trick'];
        $naString = $questionTypes['na'];

        // Remove the meta-keys so we can random pick the question categories safely
        unset($questionTypes['trick'], $questionTypes['na']);

        for ($i = 0; $i < $amount; $i++) {
            // 1. Pick a random country for the question
            $targetCountry = $countriesCollection->random();
            if (empty($targetCountry['name'])) {
                continue;
            }

            // 2. Pick a random question type
            $type = array_rand($questionTypes);

            // Handle the isolated extremely large JSON files efficiently
            $cityName = '';
            $stateName = '';
            $targetCountryEnglishName = $targetCountry['name'];

            if ($type === 'city') {
                $citiesPath = public_path('assets/country_state_city-data/cities.json');
                if (! File::exists($citiesPath)) {
                    continue;
                }
                $cityRaw = json_decode(File::get($citiesPath), true);
                if (! $cityRaw) {
                    continue;
                }
                $randomCity = $cityRaw[array_rand($cityRaw)];
                $cityName = $randomCity['name'];

                $targetCountryEnglishName = $randomCity['country_name'];
                $countryObj = $countriesCollection->firstWhere('name', $targetCountryEnglishName);
                $correctAnswer = $countryObj ? ($this->getLocalizedCountryName($countryObj, $lang) ?? $targetCountryEnglishName) : $targetCountryEnglishName;

                unset($cityRaw); // Free memory immediately

                $questionText = str_replace(':entity', $cityName, $questionTypes[$type]);
            } elseif ($type === 'state') {
                $statesPath = public_path('assets/country_state_city-data/states.json');
                if (! File::exists($statesPath)) {
                    continue;
                }
                $statesRaw = json_decode(File::get($statesPath), true);
                if (! $statesRaw) {
                    continue;
                }
                $randomState = $statesRaw[array_rand($statesRaw)];
                $stateName = $randomState['name'];

                $targetCountryEnglishName = $randomState['country_name'];
                $countryObj = $countriesCollection->firstWhere('name', $targetCountryEnglishName);
                $correctAnswer = $countryObj ? ($this->getLocalizedCountryName($countryObj, $lang) ?? $targetCountryEnglishName) : $targetCountryEnglishName;

                unset($statesRaw); // Free memory immediately

                $questionText = str_replace(':entity', $stateName, $questionTypes[$type]);
            } else {
                $localizedName = $this->getLocalizedCountryName($targetCountry, $lang) ?? $targetCountryEnglishName;
                $questionText = str_replace(':country', $localizedName, $questionTypes[$type]);
                $correctAnswer = $this->getAnswerForType($targetCountry, $type);
            }

            // Sometimes the parameter might be empty in the JSON, fallback to another try
            if (empty($correctAnswer)) {
                $i--; // Retry this iteration

                continue;
            }

            // 4. Generate wrong answers by picking a larger pool to avoid duplicates
            $wrongCountries = $countriesCollection->where('name', '!=', $targetCountryEnglishName)->random(15);
            $wrongAnswers = [];
            foreach ($wrongCountries as $wrong) {
                // If it's city/state, the wrong answers are simply random country names
                $wrongAns = ($type === 'city' || $type === 'state') ? ($this->getLocalizedCountryName($wrong, $lang) ?? $wrong['name']) : $this->getAnswerForType($wrong, $type);
                if (! empty($wrongAns) && $wrongAns !== $correctAnswer && ! in_array($wrongAns, $wrongAnswers)) {
                    $wrongAnswers[] = $wrongAns;
                }
                if (count($wrongAnswers) === 3) {
                    break;
                }
            }

            // Fallback just in case the dataset is extremely sparse for a specific property
            while (count($wrongAnswers) < 3) {
                $wrongAnswers[] = $naString.' ('.uniqid().')';
            }

            // 5. Structure the final payload with the "Ninguna de las anteriores" 15% trick chance
            $trickUsed = false;
            if (rand(1, 100) <= 15) {
                $correctAnswer = $trickString;
                $trickUsed = true;
            }

            $options = $wrongAnswers;
            $options[] = $trickUsed ? $trickString : $correctAnswer;
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
     * Generate random questions focused on Flags.
     */
    public function generateFlagsTrivia(int $amount = 5, string $lang = 'es'): array
    {
        ini_set('memory_limit', '512M');

        $countries = Cache::get('world_data_json_light_v2');
        if (empty($countries)) {
            // Need to call world trivia dummy to cache it if skipped (very rare edge case)
            $this->generateWorldTrivia(1);
            $countries = Cache::get('world_data_json_light_v2');
            if (empty($countries)) {
                return [];
            }
        }

        $questions = [];
        $countriesCollection = collect($countries)->filter(function ($c) {
            return ! empty($c['name']) && ! empty($c['iso2']);
        });

        for ($i = 0; $i < $amount; $i++) {
            $targetCountry = $countriesCollection->random();
            $countryName = $targetCountry['name'];
            $iso2 = strtolower($targetCountry['iso2']);

            // Validate flag SVG exists locally
            $flagPath = "assets/country-flags/{$iso2}.svg";
            if (! File::exists(public_path($flagPath))) {
                $i--;

                continue;
            }

            $questionTemplates = [
                'es' => '¿A qué país pertenece esta bandera?',
                'en' => 'Which country does this flag belong to?',
                'fr' => 'À quel pays appartient ce drapeau ?',
                'de' => 'Zu welchem Land gehört diese Flagge?',
                'it' => 'A quale paese appartiene questa bandiera?',
                'pt' => 'A que país pertence esta bandeira?',
                'ko' => '이 국기는 어느 나라 국기입니까?',
                'ja' => 'この国旗はどの国のものですか？',
                'fa' => 'این پرچم متعلق به کدام کشور است؟',
                'ru' => 'Какой стране принадлежит этот флаг?',
                'zh-CN' => '这面国旗属于哪个国家？',
            ];
            $questionText = $questionTemplates[$lang] ?? $questionTemplates['es'];
            $correctAnswer = $this->getLocalizedCountryName($targetCountry, $lang) ?? $countryName;

            $wrongCountries = $countriesCollection->where('name', '!=', $countryName)->random(3);
            $wrongAnswers = $wrongCountries->map(fn ($c) => $this->getLocalizedCountryName($c, $lang) ?? $c['name'])->toArray();

            $options = array_merge([$correctAnswer], $wrongAnswers);
            shuffle($options);

            $questions[] = [
                'id' => 'q_flags_'.uniqid(),
                'question' => $questionText,
                'image' => asset($flagPath),
                'options' => $options,
                'correct_answer' => $correctAnswer,
                'points' => 10,
                'type' => 'json_flags',
            ];
        }

        return $questions;
    }

    /**
     * Generate random questions focused on Country Team Shields.
     */
    public function generateShieldsTrivia(int $amount = 5, string $lang = 'es'): array
    {
        ini_set('memory_limit', '512M');

        $countries = Cache::get('world_data_json_light_v2');
        if (empty($countries)) {
            $this->generateWorldTrivia(1);
            $countries = Cache::get('world_data_json_light_v2');
            if (empty($countries)) {
                return [];
            }
        }

        $questions = [];
        $countriesCollection = collect($countries)->filter(function ($c) {
            return ! empty($c['name']) && ! empty($c['iso2']);
        });

        for ($i = 0; $i < $amount; $i++) {
            $targetCountry = $countriesCollection->random();
            $countryName = $targetCountry['name'];
            $iso2 = strtolower($targetCountry['iso2']);

            // Validate shield image exists (check for SVG, PNG or WebP just in case)
            $shieldPath = null;
            $extensions = ['svg', 'png', 'webp'];
            foreach ($extensions as $ext) {
                if (File::exists(public_path("assets/country-teams-shields/{$iso2}.{$ext}"))) {
                    $shieldPath = "assets/country-teams-shields/{$iso2}.{$ext}";
                    break;
                }
            }

            if (! $shieldPath) {
                $i--; // Retry

                continue;
            }

            $questionTemplates = [
                'es' => '¿A qué selección nacional pertenece este escudo?',
                'en' => 'Which national team does this shield belong to?',
                'fr' => 'À quelle équipe nationale appartient cet écusson ?',
                'de' => 'Zu welcher Nationalmannschaft gehört dieses Wappen?',
                'it' => 'A quale nazionale appartiene questo scudetto?',
                'pt' => 'A que seleção nacional pertence este escudo?',
                'ko' => '이 방패는 어느 국가 대표팀의 것인가요?',
                'ja' => 'この盾はどの国の代表チームのものですか？',
                'fa' => 'این سپر متعلق به کدام تیم ملی است؟',
                'ru' => 'Какой национальной сборной принадлежит этот щит?',
                'zh-CN' => '这个徽章属于哪支国家队？',
            ];
            $questionText = $questionTemplates[$lang] ?? $questionTemplates['es'];
            $correctAnswer = $this->getLocalizedCountryName($targetCountry, $lang) ?? $countryName;

            $wrongCountries = $countriesCollection->where('name', '!=', $countryName)->random(3);
            $wrongAnswers = $wrongCountries->map(fn ($c) => $this->getLocalizedCountryName($c, $lang) ?? $c['name'])->toArray();

            $options = array_merge([$correctAnswer], $wrongAnswers);
            shuffle($options);

            $questions[] = [
                'id' => 'q_shields_'.uniqid(),
                'question' => $questionText,
                'image' => asset($shieldPath),
                'options' => $options,
                'correct_answer' => $correctAnswer,
                'points' => 15, // A bit harder, so 15 pts
                'type' => 'json_shields',
            ];
        }

        return $questions;
    }

    /**
     * Generate random questions focused on Country Names (Languages & Translations).
     */
    public function generateLanguageTrivia(int $amount = 5, string $lang = 'es'): array
    {
        ini_set('memory_limit', '512M');

        // Note: we fetch v2 cache here! It has the translations.
        // If the cache was flushed, the global helper will re-build it containing translations.
        $countries = Cache::get('world_data_json_light_v2');
        if (empty($countries)) {
            $this->generateWorldTrivia(1);
            $countries = Cache::get('world_data_json_light_v2');
            if (empty($countries)) {
                return [];
            }
        }

        $questions = [];
        $countriesCollection = collect($countries)->filter(function ($c) {
            return ! empty($c['name']) && ! empty($c['translations']);
        });

        // Dictionary to map json language codes to readable strings
        $langNames = [
            'ko' => 'Coreano',
            'pt' => 'Portugués',
            'de' => 'Alemán',
            'es' => 'Español',
            'fr' => 'Francés',
            'ja' => 'Japonés',
            'it' => 'Italiano',
            'fa' => 'Persa',
            'ru' => 'Ruso',
            'zh-CN' => 'Chino (Simplificado)',
        ];

        for ($i = 0; $i < $amount; $i++) {
            $targetCountry = $countriesCollection->random();
            if (empty($targetCountry['translations']) || ! is_array($targetCountry['translations'])) {
                $i--; // Retry

                continue;
            }

            // Pick a random available translation that is naturally not empty
            $availableLangs = array_filter($targetCountry['translations']);
            if (empty($availableLangs)) {
                $i--;

                continue;
            }

            $langCode = array_rand($availableLangs);
            $translatedName = $availableLangs[$langCode];
            $readableLang = $langNames[$langCode] ?? $langCode;

            $questionTemplates = [
                'es' => "¿De qué país es el nombre ':name' (en :lang)?",
                'en' => "Which country is named ':name' (in :lang)?",
                'fr' => "De quel pays vient le nom ':name' (en :lang) ?",
                'de' => "Zu welchem Land gehört der Name ':name' (auf :lang)?",
                'it' => "A quale paese appartiene il nome ':name' (in :lang)?",
                'pt' => "De qual país é o nome ':name' (em :lang)?",
                'ko' => "':name'은/는 어느 나라 이름입니까 (:lang로)?",
                'ja' => "':name'はどの国の名前ですか（:langで）？",
                'fa' => "نام ':name' متعلق به کدام کشور است (به زبان :lang)؟",
                'ru' => "Какой стране принадлежит название ':name' (на языке :lang)?",
                'zh-CN' => "':name' 是哪个国家的名字（用 :lang）？",
            ];
            $template = $questionTemplates[$lang] ?? $questionTemplates['es'];
            $questionText = str_replace([':name', ':lang'], [$translatedName, $readableLang], $template);

            $correctAnswer = $this->getLocalizedCountryName($targetCountry, $lang) ?? $targetCountry['name'];

            $wrongCountries = $countriesCollection->where('name', '!=', $targetCountry['name'])->random(3);
            $wrongAnswers = $wrongCountries->map(fn ($c) => $this->getLocalizedCountryName($c, $lang) ?? $c['name'])->toArray();

            $options = array_merge([$correctAnswer], $wrongAnswers);
            shuffle($options);

            $questions[] = [
                'id' => 'q_lang_'.uniqid(),
                'question' => $questionText,
                'options' => $options,
                'correct_answer' => $correctAnswer,
                'points' => 15,
                'type' => 'json_lang',
            ];
        }

        return $questions;
    }

    /**
     * Helper to get Localized Country Name safely decoding translations if they exist.
     */
    private function getLocalizedCountryName(?array $country, string $lang): ?string
    {
        if (! $country) {
            return null;
        }

        $name = $country['name'] ?? null;
        if ($lang === 'en' || empty($name)) {
            return $name;
        }

        if (! empty($country['translations'][$lang])) {
            return $country['translations'][$lang];
        }

        return $name;
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

    /**
     * Generate trivia questions for Country Silhouettes.
     */
    public function generateSilhouetteTrivia(int $amount = 5, string $lang = 'es'): array
    {
        ini_set('memory_limit', '512M');

        // Load names index
        $namesPath = public_path('data/silhouettes-names.json');
        if (! File::exists($namesPath)) {
            return [];
        }

        $availableNames = json_decode(File::get($namesPath), true);
        if (! is_array($availableNames) || empty($availableNames)) {
            return [];
        }

        // Load country translations from the specific file requested by the user
        $countriesPath = public_path('assets/country_state_city-data/countries.json');
        if (! File::exists($countriesPath)) {
            return [];
        }

        $countriesData = json_decode(File::get($countriesPath), true);
        if (! is_array($countriesData)) {
            return [];
        }

        $countriesCollection = collect($countriesData);

        $questions = [];
        $templates = [
            'es' => '¿A qué país pertenece esta silueta?',
            'en' => 'Which country does this silhouette belong to?',
            'fr' => 'À quel pays appartient cette silhouette ?',
            'de' => 'Zu welchem Land gehört diese Silhouette?',
            'it' => 'A quale paese appartiene questa silhouette?',
            'pt' => 'A que país pertence esta silhueta?',
            'ko' => '이 실루엣은 어느 나라의 것입니까?',
            'ja' => 'このシルエットはどの国のものですか？',
            'fa' => 'این سیلت متعلق به کدام کشور است؟',
            'ru' => 'Какой стране принадлежит этот силуэт?',
            'zh-CN' => '这个剪影属于哪个国家？',
        ];

        $questionText = $templates[$lang] ?? $templates['es'];

        for ($i = 0; $i < $amount; $i++) {
            if (count($availableNames) < 4) {
                break;
            }

            // Pick 4 random items from the available silhouettes index
            $optionsDataRaw = collect($availableNames)->random(4);
            $correctDataRaw = $optionsDataRaw->random();

            $optionsNames = $optionsDataRaw->map(function ($item) use ($countriesCollection, $lang) {
                $nameRaw = is_array($item) ? $item['name'] : $item;
                $iso2Raw = is_array($item) ? ($item['iso2'] ?? null) : null;
                $iso3Raw = is_array($item) ? ($item['iso3'] ?? null) : null;

                // Robust matching: ISO2 -> ISO3 -> Search in ALL name fields
                $countryMatch = $countriesCollection->first(function ($c) use ($nameRaw, $iso2Raw, $iso3Raw) {
                    if ($iso2Raw && isset($c['iso2']) && strtolower($c['iso2']) === strtolower($iso2Raw)) {
                        return true;
                    }
                    if ($iso3Raw && isset($c['iso3']) && strtolower($c['iso3']) === strtolower($iso3Raw)) {
                        return true;
                    }

                    $cleanNameRaw = strtolower(trim($nameRaw));
                    if (strtolower($c['name'] ?? '') === $cleanNameRaw) {
                        return true;
                    }

                    // Check ALL translations for a match
                    if (isset($c['translations']) && is_array($c['translations'])) {
                        foreach ($c['translations'] as $tName) {
                            if ($tName && strtolower($tName) === $cleanNameRaw) {
                                return true;
                            }
                        }
                    }

                    return false;
                });

                if ($countryMatch) {
                    return $countryMatch['translations'][$lang] ?? $countryMatch['name'];
                }

                return $nameRaw;
            })->shuffle()->toArray();

            // Resolve correct answer localized name with same robust matching
            $correctNameRaw = is_array($correctDataRaw) ? $correctDataRaw['name'] : $correctDataRaw;
            $cIso2 = is_array($correctDataRaw) ? ($correctDataRaw['iso2'] ?? null) : null;
            $cIso3 = is_array($correctDataRaw) ? ($correctDataRaw['iso3'] ?? null) : null;

            $correctCountryMatch = $countriesCollection->first(function ($c) use ($correctNameRaw, $cIso2, $cIso3) {
                if ($cIso2 && isset($c['iso2']) && strtolower($c['iso2']) === strtolower($cIso2)) {
                    return true;
                }
                if ($cIso3 && isset($c['iso3']) && strtolower($c['iso3']) === strtolower($cIso3)) {
                    return true;
                }

                $cleanCorrectNameRaw = strtolower(trim($correctNameRaw));
                if (strtolower($c['name'] ?? '') === $cleanCorrectNameRaw) {
                    return true;
                }

                if (isset($c['translations']) && is_array($c['translations'])) {
                    foreach ($c['translations'] as $tName) {
                        if ($tName && strtolower($tName) === $cleanCorrectNameRaw) {
                            return true;
                        }
                    }
                }

                return false;
            });

            $correctAnswer = $correctCountryMatch ? ($correctCountryMatch['translations'][$lang] ?? $correctCountryMatch['name']) : $correctNameRaw;

            $questions[] = [
                'id' => 'q_sil_'.uniqid(),
                'question' => $questionText,
                'options' => $optionsNames,
                'correct_answer' => $correctAnswer,
                'correct_name_raw' => $correctNameRaw, // Reference for D3.js
                'points' => 15,
                'type' => 'silhouette',
            ];

            // Avoid repeats (availableNames is now array of objects, but handle array of strings too)
            $availableNames = collect($availableNames)->filter(function ($item) use ($correctNameRaw) {
                $name = is_array($item) ? $item['name'] : $item;

                return $name !== $correctNameRaw;
            })->values()->toArray();
        }

        return $questions;
    }
}
