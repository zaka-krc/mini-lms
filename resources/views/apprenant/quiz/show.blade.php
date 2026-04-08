@extends('layouts.app')

@section('title', $quiz->titre)

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $quiz->titre }}</h1>
            <p class="text-gray-600 mt-1">Section: <strong>{{ $quiz->sousChapitre->titre ?? 'N/A' }}</strong></p>
            <a href="{{ route('apprenant.sous-chapitre.show', $quiz->sousChapitre) }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Retour à la section
            </a>
        </div>
    </div>

    {{-- Informations du quiz --}}
    <div class="grid grid-cols-4 gap-4 mb-6 py-4 border-t border-b">
        <div class="text-center">
            <p class="text-gray-600 text-sm">Questions</p>
            <p class="text-2xl font-bold text-blue-600">{{ $quiz->questions->count() }}</p>
        </div>
        <div class="text-center">
            <p class="text-gray-600 text-sm">Temps limite</p>
            <p class="text-xl font-bold text-blue-600">{{ $quiz->temps_limite ?? '∞' }} min</p>
        </div>
        <div class="text-center">
            <p class="text-gray-600 text-sm">Note minimale</p>
            <p class="text-xl font-bold text-blue-600">{{ $quiz->note_minimale ?? 50 }}%</p>
        </div>
        <div class="text-center">
            <p class="text-gray-600 text-sm">Niveau</p>
            <p class="text-xl font-bold text-orange-600">Moyen</p>
        </div>
    </div>

    {{-- Description --}}
    @if ($quiz->description)
        <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <p class="text-gray-700">{{ $quiz->description }}</p>
        </div>
    @endif

    {{-- Bouton commencer --}}
    <div class="text-center mb-6">
        <form action="{{ route('apprenant.quiz.repondre', $quiz) }}" method="GET" class="inline">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg transition flex items-center gap-2 justify-center mx-auto text-lg">
                <i class="fas fa-play-circle"></i> Commencer le Quiz
            </button>
        </form>
    </div>

    {{-- Résultats précédents --}}
    @php
        $resultats = $quiz->notes()->where('user_id', auth()->id())->orderByDesc('created_at')->limit(5)->get();
    @endphp

    @if ($resultats->count())
        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Vos résultats précédents</h2>
            <div class="space-y-2">
                @foreach ($resultats as $resultat)
                    <div class="flex items-center justify-between p-3 bg-white rounded border border-gray-100">
                        <span class="text-gray-700">{{ $resultat->created_at->format('d/m/Y H:i') }}</span>
                        <div class="flex items-center gap-4">
                            <span class="text-sm text-gray-600">Note: </span>
                            <span class="text-lg font-bold {{ $resultat->note_sur_20 >= ($quiz->note_minimale ?? 10) ? 'text-green-600' : 'text-red-600' }}">
                                {{ $resultat->note_sur_20 }}/20
                            </span>
                            @if ($resultat->note_sur_20 >= ($quiz->note_minimale ?? 10))
                                <span class="px-3 py-1 rounded text-xs font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>Réussi
                                </span>
                            @else
                                <span class="px-3 py-1 rounded text-xs font-semibold bg-red-100 text-red-800">
                                    <i class="fas fa-times mr-1"></i>Échoué
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
