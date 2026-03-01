<x-app-layout>
    <div class="py-6 min-h-screen bg-gray-50 flex flex-col pt-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 w-full">
            
            <!-- Header (Progreso y Salida) -->
            <div class="flex items-center justify-between mb-8">
                <a href="{{ route('trivia.index') }}" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Abandonar
                </a>
                
                <div class="flex items-center space-x-2">
                    <div class="text-sm font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full shadow-sm">
                        <span id="question-counter">1</span> / <span id="total-questions">{{ count($questions) }}</span>
                    </div>
                </div>
            </div>

            <!-- Quiz Container -->
            <div id="quiz-container" class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 p-6 sm:p-10 relative">
                
                <!-- Progreso Bar -->
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gray-100">
                    <div id="progress-bar" class="h-full bg-indigo-500 transition-all duration-300 ease-out w-0"></div>
                </div>

                @if(empty($questions))
                    <div class="text-center py-10">
                        <span class="text-5xl">⚠️</span>
                        <h3 class="text-xl font-bold text-gray-800 mt-4">No hay preguntas disponibles</h3>
                        <p class="text-gray-500 mt-2 text-sm">Parece que no logramos generar las preguntas. Intenta de nuevo más tarde.</p>
                        <a href="{{ route('trivia.index') }}" class="mt-6 inline-block bg-indigo-600 text-white font-bold py-2 px-6 rounded-full hover:bg-indigo-700">Regresar</a>
                    </div>
                @else
                    <form id="trivia-form" method="POST" action="{{ route('trivia.submit') }}">
                        @csrf
                        <input type="hidden" name="trivia_type" value="{{ $type }}">
                        
                        <!-- Contenedor dinámico (JS Ocultará todo excepto el activo) -->
                        <div id="questions-wrapper">
                            @foreach($questions as $index => $q)
                                <div class="question-slide {{ $index === 0 ? 'block' : 'hidden' }}" data-index="{{ $index }}">
                                    
                                    <!-- ID Backend Oculto para validación posterior -->
                                    <input type="hidden" name="answers[{{ $index }}][question_id]" value="{{ $q['id'] }}">
                                    <!-- Encrypted Payload Context -->
                                    <input type="hidden" name="answers[{{ $index }}][question_text]" value="{{ encrypt($q['question']) }}">
                                    <input type="hidden" name="answers[{{ $index }}][correct_answer]" value="{{ encrypt($q['correct_answer']) }}"> 
                                    <input type="hidden" name="answers[{{ $index }}][points]" value="{{ encrypt($q['points']) }}"> 

                                    <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-8 leading-tight text-center">
                                        {{ $q['question'] }}
                                    </h3>

                                    <div class="space-y-4">
                                        @foreach($q['options'] as $optIndex => $option)
                                            <label class="relative block bg-white border-2 border-gray-200 rounded-xl px-6 py-4 cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition-all group">
                                                <input type="radio" name="answers[{{ $index }}][user_answer]" value="{{ $option }}" class="absolute opacity-0 w-0 h-0 peer option-radio" required>
                                                
                                                <!-- UI Custom Radio -->
                                                <div class="flex items-center justify-between">
                                                    <span class="text-lg font-bold text-gray-700 group-hover:text-indigo-900 peer-checked:text-indigo-700 transition-colors">{{ $option }}</span>
                                                    
                                                    <!-- Check Circle -->
                                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-500 flex items-center justify-center transition-all">
                                                        <svg class="w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                    </div>
                                                </div>
                                                
                                                <!-- Selected BG Outline -->
                                                <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-indigo-600 pointer-events-none transition-all"></div>
                                            </label>
                                        @endforeach
                                    </div>
                                    
                                    <div class="mt-8 flex justify-end">
                                        @if($index < count($questions) - 1)
                                            <button type="button" class="next-btn bg-black text-white px-8 py-3 rounded-xl font-bold text-sm tracking-wide hover:bg-gray-800 transition-colors shadow-md disabled:opacity-50" disabled>
                                                Siguiente →
                                            </button>
                                        @else
                                            <button type="submit" class="submit-btn bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold text-sm tracking-wide hover:bg-indigo-700 transition-colors shadow-lg disabled:opacity-50" disabled>
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
            document.addEventListener('DOMContentLoaded', function() {
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

                // Listen to Radio Clicks to enable Next/Submit logically
                radios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        const currentSlide = this.closest('.question-slide');
                        const theNextBtn = currentSlide.querySelector('.next-btn');
                        const theSubmitBtn = currentSlide.querySelector('.submit-btn');
                        
                        if(theNextBtn) theNextBtn.disabled = false;
                        if(theSubmitBtn) theSubmitBtn.disabled = false;
                    });
                });

                // Next Button workflow
                nextBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
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
    @endif
</x-app-layout>
