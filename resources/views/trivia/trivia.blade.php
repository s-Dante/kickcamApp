@foreach($questions as $question)
    <div class="mb-8 p-4 bg-white shadow rounded">
        <h3 class="text-lg font-bold">{{ $question->question_text }}</h3>
        <div class="grid grid-cols-1 gap-2 mt-4">
            @foreach($question->answer as $answer)
                <button class="p-2 border rounded hover:bg-blue-500 hover:text-white transition">
                    {{ $answer->answer_text }}
                </button>
            @endforeach
        </div>
    </div>
@endforeach