@extends('layouts.app')

@section('title', $quiz->titre)

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $quiz->titre }}</h1>
            <p class="text-gray-600 mt-1">Sous-chapitre: <strong>{{ $quiz->sousChapitre->titre ?? 'N/A' }}</strong></p>
            <a href="{{ route('admin.quiz.index') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Retour aux quiz
            </a>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.quiz.edit', $quiz) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <form method="POST" action="{{ route('admin.quiz.destroy', $quiz) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </form>
        </div>
    </div>

    {{-- Informations --}}
    <div class="grid grid-cols-4 gap-4 mb-6 py-4 border-t border-b">
        <div class="text-center">
            <p class="text-gray-600 text-sm">Questions</p>
            <p class="text-2xl font-bold text-blue-600">{{ $quiz->questions->count() }}</p>
        </div>
        <div class="text-center">
            <p class="text-gray-600 text-sm">Temps limite</p>
            <p class="text-lg font-semibold text-gray-700">{{ $quiz->temps_limite ?? 0 }} min</p>
        </div>
        <div class="text-center">
            <p class="text-gray-600 text-sm">Note minimale</p>
            <p class="text-lg font-semibold text-gray-700">{{ $quiz->note_minimale ?? 0 }}%</p>
        </div>
        <div class="text-center">
            <p class="text-gray-600 text-sm">Créé le</p>
            <p class="text-sm font-semibold text-gray-700">{{ $quiz->created_at->format('d/m/Y') }}</p>
        </div>
    </div>

    {{-- Description --}}
    @if ($quiz->description)
        <div class="mb-8 pb-8 border-b">
            <h2 class="text-xl font-semibold text-gray-800 mb-3">Description</h2>
            <p class="text-gray-600 leading-relaxed">{{ $quiz->description }}</p>
        </div>
    @endif

    {{-- Questions --}}
    <div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Questions</h2>
            <a href="{{ route('admin.questions.create', ['quiz_id' => $quiz->id]) }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Ajouter Question
            </a>
        </div>

        @if ($quiz->questions->count())
            <div class="space-y-3">
                @foreach ($quiz->questions as $question)
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 hover:border-blue-400 transition">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">{{ $question->texte }}</h3>
                                <p class="text-sm text-gray-600">{{ $question->reponses->count() }} réponses</p>
                            </div>
                            <a href="{{ route('admin.questions.show', $question) }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Aucune question pour ce quiz.</p>
        @endif
    </div>
</div>
@endsection
