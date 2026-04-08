@extends('layouts.app')

@section('title', 'Résultats du Quiz')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Résultats du Quiz</h1>
        <p class="text-gray-600 mt-1">{{ $note->quiz->titre }}</p>
    </div>

    {{-- Résultat principal --}}
    <div class="mb-6">
        <div class="bg-gradient-to-r {{ $note->score >= ($note->quiz->note_minimale ?? 50) ? 'from-green-400 to-green-600' : 'from-red-400 to-red-600' }} p-8 rounded-lg text-white text-center">
            <p class="text-lg font-semibold opacity-90 mb-2">Votre score</p>
            <div class="text-6xl font-bold">{{ $note->score }}%</div>
            <p class="mt-4 text-lg font-semibold">
                @if ($note->score >= ($note->quiz->note_minimale ?? 50))
                    <i class="fas fa-check-circle mr-2"></i>Quiz réussi!
                @else
                    <i class="fas fa-times-circle mr-2"></i>Quiz échoué
                @endif
            </p>
            <p class="text-sm mt-2 opacity-90">
                Note minimale requise: {{ $note->quiz->note_minimale ?? 50 }}%
            </p>
        </div>
    </div>

    {{-- Statistiques --}}
    <div class="grid grid-cols-4 gap-4 mb-6 py-4 border-t border-b">
        <div class="text-center">
            <p class="text-gray-600 text-sm">Questions</p>
            <p class="text-2xl font-bold text-blue-600">{{ $note->quiz->questions->count() }}</p>
        </div>
        <div class="text-center">
            <p class="text-gray-600 text-sm">Points obtenus</p>
            <p class="text-2xl font-bold text-blue-600">
                {{ round(($note->score / 100) * $note->quiz->questions->count()) }}/{{ $note->quiz->questions->count() }}
            </p>
        </div>
        <div class="text-center">
            <p class="text-gray-600 text-sm">Date du passage</p>
            <p class="text-lg font-semibold text-gray-700">{{ $note->created_at->format('d/m/Y') }}</p>
        </div>
        <div class="text-center">
            <p class="text-gray-600 text-sm">Heure</p>
            <p class="text-lg font-semibold text-gray-700">{{ $note->created_at->format('H:i') }}</p>
        </div>
    </div>

    {{-- Explications et conseils --}}
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Résumé de votre performance</h2>
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
            @if ($note->score >= ($note->quiz->note_minimale ?? 50))
                <p class="text-blue-800">
                    <i class="fas fa-thumbs-up mr-2"></i>
                    Excellents résultats! Vous avez maîtrisé le contenu de cette section.
                </p>
            @else
                <p class="text-orange-800">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Vous n'avez pas atteint la note minimale. Nous vous recommandons de relire le contenu et de réessayer.
                </p>
            @endif
        </div>
    </div>

    {{-- Boutons d'action --}}
    <div class="flex gap-4">
        <a href="{{ route('apprenant.quiz.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2">
            <i class="fas fa-list"></i> Retour aux quiz
        </a>
        @if ($note->score < ($note->quiz->note_minimale ?? 50))
            <a href="{{ route('apprenant.quiz.show', $note->quiz) }}" class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-redo"></i> Recommencer
            </a>
        @endif
        <a href="{{ route('apprenant.sous-chapitres.show', $note->quiz->sousChapitre) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2">
            <i class="fas fa-book"></i> Relire la section
        </a>
    </div>
</div>
@endsection
