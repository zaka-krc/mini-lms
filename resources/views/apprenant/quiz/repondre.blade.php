@extends('layouts.app')

@section('title', 'Quiz: ' . $quiz->titre)

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ $quiz->titre }}</h1>
        <p class="text-gray-600 mt-1">Répondez à toutes les questions ci-dessous</p>
    </div>

    {{-- Timer et progression --}}
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Question <span class="font-bold" id="current-question">1</span> / <span class="font-bold">{{ $quiz->questions->count() }}</span></p>
            <div class="w-96 bg-gray-300 rounded-full h-2 mt-2">
                <div id="progress-bar" class="bg-blue-600 h-2 rounded-full" style="width: 0%"></div>
            </div>
        </div>
        @if ($quiz->temps_limite)
            <div class="text-right">
                <p class="text-sm text-gray-600">Temps restant</p>
                <p class="text-2xl font-bold text-orange-600" id="timer">{{ $quiz->temps_limite }}:00</p>
            </div>
        @endif
    </div>

    {{-- Formulaire du quiz --}}
    <form action="{{ route('apprenant.quiz.repondre.store', $quiz) }}" method="POST" id="quiz-form" class="space-y-8">
        @csrf

        @foreach ($quiz->questions as $index => $question)
            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200" id="question-{{ $question->id }}">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">
                        {{ $index + 1 }}
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ $question->texte }}</h3>

                        {{-- Réponses (choix multiple) --}}
                        <div class="space-y-3">
                            @foreach ($question->reponses->shuffle() as $reponse)
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-blue-50 cursor-pointer transition">
                                    <input type="radio" name="responses[{{ $question->id }}]" value="{{ $reponse->id }}" required class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                                    <span class="ml-3 text-gray-700">{{ $reponse->texte }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Bouton soumettre --}}
        <div class="flex gap-4 pt-6 border-t">
            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir soumettre votre quiz? Vous ne pourrez pas le modifier après.')" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-check"></i> Soumettre le Quiz
            </button>
            <a href="{{ route('apprenant.quiz.show', $quiz) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-times"></i> Annuler
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Timer
    @if ($quiz->temps_limite)
        let timeLeft = {{ $quiz->temps_limite * 60 }};
        setInterval(() => {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            document.getElementById('timer').textContent = 
                minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
            
            if (timeLeft <= 60) {
                document.getElementById('timer').classList.add('text-red-600');
            }
            
            if (timeLeft <= 0) {
                document.getElementById('quiz-form').submit();
            }
            timeLeft--;
        }, 1000);
    @endif

    // Progress bar
    document.querySelectorAll('input[type="radio"]').forEach(input => {
        input.addEventListener('change', () => {
            const answered = document.querySelectorAll('input[type="radio"]:checked').length;
            const total = document.querySelectorAll('input[type="radio"]').length / {{ $quiz->questions->count() }};
            const progress = (answered / total) * 100;
            document.getElementById('progress-bar').style.width = progress + '%';
            document.getElementById('current-question').textContent = answered;
        });
    });
</script>
@endpush
@endsection
