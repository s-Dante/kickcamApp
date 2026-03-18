@php
    $classes = [
        'page' => [
            'container' => 'py-6 min-h-screen flex flex-col pt-8',
            'wrapper' => 'max-w-3xl mx-auto px-4 sm:px-6 w-full',
        ],
        'header' => [
            'container' => 'flex items-center justify-between mb-8',
            'back_link' => "flex items-center text-sm font-medium {$ui['text-muted']} hover:text-secondary-sat transition-colors",
            'back_icon' => 'w-5 h-5 mr-1',
            'counter_wrapper' => 'flex items-center space-x-2',
            'counter' => 'text-sm font-bold text-accent-sat bg-accent-desat px-3 py-1 rounded-full shadow-sm border border-accent/20'
        ],
        'quiz' => [
            'container' => "{$ui['card']} sm:p-10 relative overflow-hidden",
            'progress_bg' => 'absolute top-0 left-0 w-full h-1.5 bg-tertiary',
            'progress_bar' => 'h-full bg-accent hover:bg-accent-sat transition-all duration-300 ease-out w-0',
            'empty' => [
                'container' => 'text-center py-10',
                'icon' => 'text-5xl',
                'title' => "{$ui['h2']} mt-4",
                'desc' => "{$ui['text-muted']} mt-2 text-sm",
                'btn' => "mt-6 {$ui['btn-primary']}"
            ],
            'form_wrapper' => 'p-6',
            'flag_container' => 'w-full max-w-sm mx-auto mb-6 flex justify-center items-center rounded-xl p-4 bg-primary/20 border-2 border-tertiary-desat shadow-inner',
            'flag_image' => 'h-32 object-contain drop-shadow-md rounded',
            'question_title' => 'text-xl sm:text-2xl font-extrabold text-secondary-sat mb-8 leading-tight text-center',
            'options_wrapper' => 'space-y-4',
            'option_label' => "relative block {$ui['card']} border-2 border-tertiary hover:border-accent hover:bg-accent-desat/10 transition-all group cursor-pointer overflow-hidden",
            'option_input' => 'absolute opacity-0 w-0 h-0 peer option-radio',
            'option_content' => 'flex items-center justify-between p-4 relative z-10 peer-checked:[&>span]:text-accent-sat peer-checked:[&_.check-bg]:border-accent peer-checked:[&_.check-bg]:bg-accent peer-checked:[&_.check-icon]:opacity-100',
            'option_text' => 'text-base sm:text-lg font-bold text-secondary group-hover:text-accent-sat transition-colors',
            'option_check_bg' => 'check-bg w-6 h-6 rounded-full border-2 border-tertiary flex items-center justify-center transition-all',
            'option_check_icon' => 'check-icon w-3.5 h-3.5 text-white opacity-0 transition-opacity',
            'option_outline' => 'absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-accent peer-checked:bg-accent-desat/10 pointer-events-none transition-all',
            'actions' => 'mt-8 flex justify-end',
            'btn_next' => "next-btn {$ui['btn-secondary']} disabled:opacity-50",
            'btn_submit' => "submit-btn {$ui['btn-primary']} disabled:opacity-50"
        ]
    ];
@endphp

<x-app-layout>
    <div class="{{ $classes['page']['container'] }}">
        <div class="{{ $classes['page']['wrapper'] }}">

            <!-- Header (Progreso y Salida) -->
            <div class="{{ $classes['header']['container'] }}">
                <a href="{{ route('trivia.index') }}" class="{{ $classes['header']['back_link'] }}">
                    <svg class="{{ $classes['header']['back_icon'] }}" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Abandonar
                </a>

                <div class="{{ $classes['header']['counter_wrapper'] }}">
                    <div class="{{ $classes['header']['counter'] }}">
                        <span id="question-counter">1</span> / <span id="total-questions">{{ count($questions) }}</span>
                    </div>
                </div>
            </div>

            <!-- Quiz Container -->
            <div id="quiz-container" class="{{ $classes['quiz']['container'] }}">

                <!-- Progreso Bar -->
                <div class="{{ $classes['quiz']['progress_bg'] }}">
                    <div id="progress-bar" class="{{ $classes['quiz']['progress_bar'] }}"></div>
                </div>

                @if(empty($questions))
                    <div class="{{ $classes['quiz']['empty']['container'] }}">
                        <span class="{{ $classes['quiz']['empty']['icon'] }}">⚠️</span>
                        <h3 class="{{ $classes['quiz']['empty']['title'] }}">No hay preguntas disponibles</h3>
                        <p class="{{ $classes['quiz']['empty']['desc'] }}">Parece que no logramos generar las preguntas.
                            Intenta de nuevo más tarde.</p>
                        <a href="{{ route('trivia.index') }}" class="{{ $classes['quiz']['empty']['btn'] }}">Regresar</a>
                    </div>
                @else
                    <form id="trivia-form" method="POST" action="{{ route('trivia.submit') }}">
                        @csrf
                        <input type="hidden" name="trivia_type" value="{{ $type }}">

                        <!-- Contenedor dinámico (JS Ocultará todo excepto el activo) -->
                        <div id="questions-wrapper" class="{{ $classes['quiz']['form_wrapper'] }}">
                            @foreach($questions as $index => $q)
                                <div class="question-slide {{ $index === 0 ? 'block' : 'hidden' }}" data-index="{{ $index }}">

                                    <!-- ID Backend Oculto para validación posterior -->
                                    <input type="hidden" name="answers[{{ $index }}][question_id]" value="{{ $q['id'] }}">
                                    <!-- Encrypted Payload Context -->
                                    <input type="hidden" name="answers[{{ $index }}][question_text]"
                                        value="{{ encrypt($q['question']) }}">
                                    <input type="hidden" name="answers[{{ $index }}][correct_answer]"
                                        value="{{ encrypt($q['correct_answer']) }}">
                                    <input type="hidden" name="answers[{{ $index }}][points]"
                                        value="{{ encrypt($q['points']) }}">
                                    @if(isset($q['correct_name_raw']))
                                        <input type="hidden" name="answers[{{ $index }}][image]"
                                            value="{{ encrypt($q['correct_name_raw']) }}">
                                    @endif

                                    @if(isset($q['correct_name_raw']))
                                        <div class="{{ $classes['quiz']['flag_container'] }}">
                                            <div class="h-32 w-full flex justify-center items-center text-secondary-sat dark:text-secondary-desat drop-shadow-lg transition-transform hover:scale-105 relative d3-container" data-index="{{ $index }}" data-country="{{ $q['correct_name_raw'] }}">
                                                <svg class="w-full h-full" id="d3-svg-{{ $index }}"></svg>
                                            </div>
                                        </div>
                                    @endif

                                    <h3 class="{{ $classes['quiz']['question_title'] }}">
                                        {{ $q['question'] }}
                                    </h3>

                                    <div class="{{ $classes['quiz']['options_wrapper'] }}">
                                        @foreach($q['options'] as $optIndex => $option)
                                            <label class="{{ $classes['quiz']['option_label'] }}">
                                                <input type="radio" name="answers[{{ $index }}][user_answer]" value="{{ $option }}"
                                                    class="{{ $classes['quiz']['option_input'] }}" required>

                                                <!-- UI Custom Radio -->
                                                <div class="{{ $classes['quiz']['option_content'] }}">
                                                    <span class="{{ $classes['quiz']['option_text'] }}">{{ $option }}</span>

                                                    <!-- Check Circle -->
                                                    <div class="{{ $classes['quiz']['option_check_bg'] }}">
                                                        <svg class="{{ $classes['quiz']['option_check_icon'] }}" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                                d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </div>
                                                </div>

                                                <!-- Selected BG Outline -->
                                                <div class="{{ $classes['quiz']['option_outline'] }}"></div>
                                            </label>
                                        @endforeach
                                    </div>

                                    <div class="{{ $classes['quiz']['actions'] }}">
                                        @if($index < count($questions) - 1)
                                            <button type="button" class="{{ $classes['quiz']['btn_next'] }}" disabled>
                                                Siguiente →
                                            </button>
                                        @else
                                            <button type="submit" class="{{ $classes['quiz']['btn_submit'] }}" disabled>
                                                Ver Resultados 🏆
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                @endif
            </div>

        </div>
    </div>

    <!-- Script de flujo JS Básico para interactividad tipo QuizApp -->
    @if(!empty($questions))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const slides = document.querySelectorAll('.question-slide');
                const radios = document.querySelectorAll('.option-radio');
                const nextBtns = document.querySelectorAll('.next-btn');
                const submitBtn = document.querySelector('.submit-btn');
                const counterDisplay = document.getElementById('question-counter');
                const totalQuestions = {{ count($questions) }};
                const progressBar = document.getElementById('progress-bar');

                let currentIndex = 0;

                function updateProgress() {
                    let percentage = ((currentIndex + 1) / totalQuestions) * 100;
                    progressBar.style.width = percentage + '%';
                    counterDisplay.innerText = currentIndex + 1;
                }

                // Initialize Bar
                updateProgress();

                // Listen to Radio Clicks to enable Next/Submit logically using delegation
                document.getElementById('questions-wrapper').addEventListener('change', function (e) {
                    if (e.target.classList.contains('option-radio')) {
                        const currentSlide = e.target.closest('.question-slide');
                        const theNextBtn = currentSlide.querySelector('.next-btn');
                        const theSubmitBtn = currentSlide.querySelector('.submit-btn');

                        if (theNextBtn) theNextBtn.disabled = false;
                        if (theSubmitBtn) theSubmitBtn.disabled = false;
                        
                        // Also visual feedback
                        const labels = currentSlide.querySelectorAll('label');
                        labels.forEach(l => l.classList.remove('border-accent', 'bg-accent-desat/20'));
                        e.target.closest('label').classList.add('border-accent', 'bg-accent-desat/20');
                    }
                });

                        // Next Button workflow
                nextBtns.forEach(btn => {
                    btn.addEventListener('click', function () {
                        slides[currentIndex].classList.remove('block');
                        slides[currentIndex].classList.add('hidden');

                        currentIndex++;

                        slides[currentIndex].classList.remove('hidden');
                        slides[currentIndex].classList.add('block');
                        updateProgress();
                    });
                });
            });
        </script>

        <!-- D3.js and D3-Geo for rendering accurate cartographic projections -->
        <script src="https://d3js.org/d3.v7.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', async function () {
                const containers = document.querySelectorAll('.d3-container');
                if (containers.length === 0) return;

                try {
                    // Fetch the map data once
                    const response = await fetch('/data/silhouettes.geojson');
                    if (!response.ok) throw new Error("GeoJSON not found");
                    const geojsonData = await response.json();
                    
                    // Create an index for O(1) lookups
                    const featuresMap = {};
                    geojsonData.features.forEach(f => {
                        if (f.properties && f.properties.name) {
                            featuresMap[f.properties.name] = f;
                        }
                    });

                    // Render each requested country
                    containers.forEach(container => {
                        const index = container.getAttribute('data-index');
                        const countryName = container.getAttribute('data-country');
                        const featureData = featuresMap[countryName];
                        
                        if (!featureData) {
                            console.warn("Shape not found for:", countryName);
                            return;
                        }

                        const svgElement = d3.select(`#d3-svg-${index}`);
                        
                        // We set an arbitrary canvas size, d3 will stretch/scale it perfectly
                        const width = 200, height = 200;
                        
                        // Fix for small countries (e.g., France, US): 
                        // Find the maximum polygon by area to use as the zoom bounding box, ignoring tiny remote islands.
                        let boundsFeature = featureData;
                        if (featureData.geometry.type === 'MultiPolygon') {
                            let maxArea = -1;
                            let largestPoly = null;
                            featureData.geometry.coordinates.forEach(polyCoords => {
                                const polyFeature = {type: "Polygon", coordinates: polyCoords};
                                const area = d3.geoArea(polyFeature);
                                if (area > maxArea) {
                                    maxArea = area;
                                    largestPoly = polyCoords;
                                }
                            });
                            if (largestPoly) {
                                boundsFeature = {type: "Feature", geometry: {type: "Polygon", coordinates: largestPoly}};
                            }
                        }

                        // Use a geographic projection using the bounds of the largest landmass
                        const projection = d3.geoMercator().fitSize([width, height], boundsFeature);
                        const pathGenerator = d3.geoPath().projection(projection);

                        // Calculate area to determine if it's a "tiny" country for visual polish
                        const geoArea = d3.geoArea(featureData);
                        const isTiny = geoArea < 0.0005; // Arbitrary threshold for tiny countries/islands

                        svgElement
                            .attr("viewBox", `0 0 ${width} ${height}`)
                            .append("path")
                            .datum(featureData)
                            .attr("d", pathGenerator)
                            .attr("fill", "currentColor")
                            .attr("stroke", "currentColor")
                            // Make strokes thicker for extremely small countries or if it's generally small
                            .attr("stroke-width", isTiny ? 2 : 0.5)
                            .attr("stroke-linejoin", "round")
                            .attr("class", "transition-all duration-700 ease-in-out")
                            .style("opacity", 0)
                            .transition()
                            .duration(800)
                            .style("opacity", 1);
                    });
                } catch (e) {
                    console.error("D3 Mapping Error:", e);
                }
            });
        </script>
    @endif
</x-app-layout>