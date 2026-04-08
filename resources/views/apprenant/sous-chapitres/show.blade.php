@extends('layouts.app')

@section('title', $sousChapitre->titre)

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $sousChapitre->titre }}</h1>
            <p class="text-gray-600 mt-1">
                Chapitre: <strong>{{ $sousChapitre->chapitre->titre }}</strong>
                | Formation: <strong>{{ $sousChapitre->chapitre->formation->nom }}</strong>
            </p>
            <a href="{{ route('apprenant.chapitre.show', $sousChapitre->chapitre) }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Retour au chapitre
            </a>
        </div>
    </div>

    {{-- Contenu --}}
    <div class="mb-8 pb-8 border-b">
        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 text-gray-700 leading-relaxed">
            {!! nl2br(e($sousChapitre->contenu)) !!}
        </div>
    </div>

    {{-- Quiz de cette section --}}
    @if ($sousChapitre->quizzes->count())
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-tasks text-orange-500"></i> Quiz pour évaluer vos connaissances
            </h2>
            <div class="space-y-3">
                @foreach ($sousChapitre->quizzes as $quiz)
                    <div class="bg-white p-4 rounded-lg border border-blue-100 hover:border-blue-300 transition flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $quiz->titre }}</h3>
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-question-circle mr-2"></i>
                                {{ $quiz->questions->count() }} questions
                                @if ($quiz->temps_limite)
                                    | <i class="fas fa-clock mr-2"></i>{{ $quiz->temps_limite }} minutes
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('apprenant.quiz.show', $quiz) }}" class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                            <i class="fas fa-play mr-2"></i>Commencer
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-gray-100 border border-gray-300 rounded-lg p-6 text-center">
            <p class="text-gray-600">
                <i class="fas fa-info-circle mr-2"></i>
                Aucun quiz pour cette section pour le moment.
            </p>
        </div>
    @endif
</div>
@endsection
