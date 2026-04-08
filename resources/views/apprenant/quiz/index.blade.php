@extends('layouts.app')

@section('title', 'Mes Quiz')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mes Quiz</h1>
    </div>

    {{-- Messages Flash --}}
    @if ($message = Session::get('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            {{ $message }}
        </div>
    @endif

    {{-- Liste des quiz --}}
    @if ($quizzes->count())
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($quizzes as $quiz)
                @php
                    $score = $quiz->notes()->where('apprenant_id', auth()->id())->latest()->first();
                @endphp
                
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg border border-orange-200 p-6 hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $quiz->titre }}</h3>
                    <p class="text-gray-600 text-sm mb-3">Section: <strong>{{ $quiz->sousChapitre->titre ?? 'N/A' }}</strong></p>

                    <div class="bg-white p-3 rounded mb-3 border border-orange-100">
                        <p class="text-sm text-gray-600 flex items-center gap-2">
                            <i class="fas fa-question-circle text-orange-500"></i>
                            {{ $quiz->questions->count() }} questions
                        </p>
                        @if ($quiz->temps_limite)
                            <p class="text-sm text-gray-600 flex items-center gap-2 mt-1">
                                <i class="fas fa-clock text-blue-500"></i>
                                {{ $quiz->temps_limite }} minutes
                            </p>
                        @endif
                    </div>

                    @if ($score)
                        <div class="mb-3 p-3 bg-blue-50 rounded border border-blue-100">
                            <p class="text-sm text-gray-600">Votre dernière note:</p>
                            <div class="text-2xl font-bold {{ $score->score >= ($quiz->note_minimale ?? 50) ? 'text-green-600' : 'text-red-600' }}">
                                {{ $score->score }}%
                            </div>
                        </div>
                    @endif

                    <a href="{{ route('apprenant.quiz.show', $quiz) }}" class="block w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2 px-4 rounded-lg transition text-center">
                        {{ $score ? 'Recommencer' : 'Commencer' }}
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $quizzes->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-500 text-lg">Aucun quiz disponible pour le moment.</p>
        </div>
    @endif
</div>
@endsection
