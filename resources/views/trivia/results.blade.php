@php
    $classes = [
        'page' => [
            'container' => 'py-10 bg-primary-sat min-h-screen flex flex-col',
            'wrapper' => 'max-w-3xl mx-auto px-4 sm:px-6 w-full space-y-6',
        ],
        'hero' => [
            'card' => 'bg-gradient-to-r from-accent to-accent-sat rounded-2xl shadow-xl overflow-hidden text-center text-white relative',
            'pattern' => 'absolute inset-0 opacity-20 bg-[url(\'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmYiLz48L3N2Zz4=\')]',
            'content' => 'relative z-10 p-8 sm:p-12',
            'label' => 'text-sm uppercase font-bold tracking-widest text-secondary-desat mb-2',
            'score_wrapper' => 'flex items-center justify-center mb-6',
            'score_circle' => 'w-24 h-24 sm:w-32 sm:h-32 bg-white/20 rounded-full flex flex-col items-center justify-center backdrop-blur-sm border-4 border-white',
            'score_val' => 'text-4xl sm:text-5xl font-extrabold',
            'score_total' => 'text-xs font-bold text-secondary-desat uppercase tracking-wider',
            'status' => 'text-2xl sm:text-3xl font-extrabold mb-4',
            'points_wrapper' => 'flex items-center justify-center gap-4 text-sm font-semibold mt-4',
            'points_badge' => 'bg-accent-sat/50 px-4 py-2 rounded-lg flex items-center',
            'unlocks' => 'mt-6',
            'unlocks_title' => 'text-xs text-secondary-desat uppercase tracking-widest font-bold mb-2',
            'unlocks_grid' => 'flex flex-wrap justify-center gap-2',
            'unlock_item' => 'bg-orange-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg border border-orange-400'
        ],
        'details' => [
            'card' => "{$ui['card']} p-6 overflow-hidden",
            'title' => 'text-xl font-bold text-secondary-sat mb-6 border-b border-tertiary pb-4',
            'list' => 'space-y-6',
            'item_correct' => 'bg-primary-desat rounded-xl p-5 border border-tertiary border-l-4 border-l-green-500',
            'item_wrong' => 'bg-primary-desat rounded-xl p-5 border border-tertiary border-l-4 border-l-red-500',
            'item_content' => 'flex flex-col sm:flex-row gap-6 items-center sm:items-start',
            'item_image' => 'h-16 sm:h-24 w-auto object-contain drop-shadow-md rounded',
            'item_text' => 'flex-1 w-full',
            'question' => 'font-bold text-secondary-sat text-lg mb-4 leading-tight',
            'q_num' => "text-secondary-desat text-sm font-normal mr-2",
            'answer_row' => 'flex items-center text-sm font-medium',
            'answer_label' => 'w-24 text-secondary-desat',
            'user_ans_correct' => 'flex items-center px-3 py-1 rounded-md bg-green-100 text-green-800',
            'user_ans_wrong' => 'flex items-center px-3 py-1 rounded-md bg-red-100 text-red-800',
            'correct_ans_badge' => 'flex items-center px-3 py-1 bg-green-50/50 text-green-700 rounded-md border border-green-200',
            'icon' => 'w-4 h-4 mr-1',
            'actions' => 'mt-8 pt-6 border-t border-tertiary flex justify-center',
            'btn' => 'w-full sm:w-auto text-center bg-gray-900 text-white font-bold py-3 px-10 rounded-xl hover:bg-gray-800 transition-colors shadow-lg shadow-gray-200'
        ]
    ];
@endphp

<x-app-layout>
    <div class="{{ $classes['page']['container'] }}">
        <div class="{{ $classes['page']['wrapper'] }}">

            <!-- Title & Global Result Status -->
            <div class="{{ $classes['hero']['card'] }}">
                
                <div class="{{ $classes['hero']['pattern'] }}"></div>
                
                <div class="{{ $classes['hero']['content'] }}">
                    <h2 class="{{ $classes['hero']['label'] }}">Desempeño</h2>
                    
                    <div class="{{ $classes['hero']['score_wrapper'] }}">
                        <div class="{{ $classes['hero']['score_circle'] }}">
                            <span class="{{ $classes['hero']['score_val'] }}">{{ session('score') }}</span>
                            <span class="{{ $classes['hero']['score_total'] }}">de {{ session('totalQuestions') }}</span>
                        </div>
                    </div>
                    
                    <h1 class="{{ $classes['hero']['status'] }}">{{ session('status') }}</h1>
                    
                    <div class="{{ $classes['hero']['points_wrapper'] }}">
                        <div class="{{ $classes['hero']['points_badge'] }}">
                            <span class="mr-2 text-xl">⭐️</span>
                            <span>+{{ session('totalEarnedPoints') }} pt</span>
                        </div>
                    </div>

                    @if(session('awardedItems') && count(session('awardedItems')) > 0)
                        <div class="{{ $classes['hero']['unlocks'] }}">
                            <p class="{{ $classes['hero']['unlocks_title'] }}">Nuevos Desbloqueos en Dashboard</p>
                            <div class="{{ $classes['hero']['unlocks_grid'] }}">
                                @foreach(session('awardedItems') as $item)
                                    <span class="{{ $classes['hero']['unlock_item'] }}">
                                        {{ $item }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Detailed Results Feed -->
            <div class="{{ $classes['details']['card'] }}">
                <h3 class="{{ $classes['details']['title'] }}">Detalle de Respuestas</h3>
                
                <div class="{{ $classes['details']['list'] }}">
                    @if(session('detailedResults'))
                        @foreach(session('detailedResults') as $index => $res)
                            <div class="{{ $res['is_correct'] ? $classes['details']['item_correct'] : $classes['details']['item_wrong'] }}">
                                <div class="{{ $classes['details']['item_content'] }}">
                                    <!-- Optional Flag Image for the 'Flags' game mode -->
                                    @if(isset($res['image']) && !($res['is_silhouette'] ?? false))
                                        <img src="{{ $res['image'] }}" alt="Bandera del país" class="{{ $classes['details']['item_image'] }}">
                                    @endif

                                    <!-- Silhouette for the 'Silhouette' game mode -->
                                    @if($res['is_silhouette'] ?? false)
                                        <div class="h-24 w-24 flex justify-center items-center text-secondary-sat dark:text-secondary-desat drop-shadow-md d3-result-container" data-country="{{ $res['image'] }}" data-index="{{ $index }}">
                                            <svg class="w-full h-full" id="d3-result-svg-{{ $index }}"></svg>
                                        </div>
                                    @endif

                                    <div class="{{ $classes['details']['item_text'] }}">
                                        <h4 class="{{ $classes['details']['question'] }}">
                                            <span class="{{ $classes['details']['q_num'] }}">Q{{ $index + 1 }}.</span>
                                            {{ $res['question'] }}
                                        </h4>
                                        
                                        <div class="space-y-3">
                                            <div class="{{ $classes['details']['answer_row'] }}">
                                                <span class="{{ $classes['details']['answer_label'] }}">Tu respuesta:</span>
                                                <span class="{{ $res['is_correct'] ? $classes['details']['user_ans_correct'] : $classes['details']['user_ans_wrong'] }}">
                                                    @if($res['is_correct'])
                                                        <svg class="{{ $classes['details']['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    @else
                                                        <svg class="{{ $classes['details']['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    @endif
                                                    {{ $res['user_answer'] }}
                                                </span>
                                            </div>
                                            
                                            @if(!$res['is_correct'])
                                                <div class="{{ $classes['details']['answer_row'] }}">
                                                    <span class="{{ $classes['details']['answer_label'] }}">Correcta:</span>
                                                    <span class="{{ $classes['details']['correct_ans_badge'] }}">
                                                        <svg class="{{ $classes['details']['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        {{ $res['correct_answer'] }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Action Button -->
                <div class="{{ $classes['details']['actions'] }}">
                    <a href="{{ route('trivia.index') }}" class="{{ $classes['details']['btn'] }}">
                        Volver al Catálogo ➔
                    </a>
                </div>
            </div>

        </div>
    </div>

    @if(collect(session('detailedResults'))->contains('is_silhouette', true))
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const containers = document.querySelectorAll('.d3-result-container');
            if (containers.length === 0) return;

            fetch('/data/silhouettes.geojson')
                .then(response => response.json())
                .then(data => {
                    containers.forEach(container => {
                        const countryName = container.dataset.country;
                        const index = container.dataset.index;
                        const feature = data.features.find(f => f.properties.name === countryName);
                        
                        if (feature) {
                            renderResultSilhouette(feature, index);
                        }
                    });
                });

            function renderResultSilhouette(feature, index) {
                const svg = d3.select(`#d3-result-svg-${index}`);
                const width = 96; // h-24 = 6rem = 96px
                const height = 96;

                const projection = d3.geoMercator().fitSize([width, height], feature);
                const pathGenerator = d3.geoPath().projection(projection);

                svg.append("path")
                    .datum(feature)
                    .attr("d", pathGenerator)
                    .attr("fill", "currentColor")
                    .attr("stroke", "currentColor")
                    .attr("stroke-width", 0.5);
            }
        });
    </script>
    @endif
</x-app-layout>
