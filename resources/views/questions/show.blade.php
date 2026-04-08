@extends('layouts.app')

@section('title', $question->titre)

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $question->titre }}</h1>
            <p class="text-gray-600 mt-1">Quiz: <strong>{{ $question->quiz->titre ?? 'N/A' }}</strong></p>
            <a href="{{ route('admin.questions.index') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Retour aux questions
            </a>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.questions.edit', $question) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <form method="POST" action="{{ route('admin.questions.destroy', $question) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </form>
        </div>
    </div>

    {{-- Informations --}}
    <div class="grid grid-cols-3 gap-4 mb-6 py-4 border-t border-b">
        <div class="text-center">
            <p class="text-gray-600 text-sm">Type</p>
            <p class="text-lg font-semibold text-blue-600">
                {{ $question->type === 'multiple' ? 'QCM' : 'Vrai/Faux' }}
            </p>
        </div>
        <div class="text-center">
            <p class="text-gray-600 text-sm">Points</p>
            <p class="text-lg font-semibold text-blue-600">{{ $question->points ?? 1 }}</p>
        </div>
        <div class="text-center">
            <p class="text-gray-600 text-sm">Réponses</p>
            <p class="text-lg font-semibold text-blue-600">{{ $question->reponses->count() }}</p>
        </div>
    </div>

    {{-- Explication --}}
    @if ($question->explication)
        <div class="mb-8 pb-8 border-b bg-blue-50 p-4 rounded-lg">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Explication</h2>
            <p class="text-gray-700 leading-relaxed">{{ $question->explication }}</p>
        </div>
    @endif

    {{-- Réponses --}}
    <div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Réponses</h2>
            <a href="{{ route('admin.reponses.create', ['question_id' => $question->id]) }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Ajouter Réponse
            </a>
        </div>

        @if ($question->reponses->count())
            <div class="space-y-2">
                @foreach ($question->reponses as $reponse)
                    <div class="bg-gray-50 p-4 rounded-lg border {{ $reponse->is_correct ? 'border-green-300 bg-green-50' : 'border-gray-200' }} flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            @if ($reponse->is_correct)
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-600 text-white text-sm font-bold">✓</span>
                            @else
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-400 text-white text-sm font-bold">✗</span>
                            @endif
                            <div>
                                <p class="text-gray-800 font-medium">{{ $reponse->titre }}</p>
                                @if ($reponse->is_correct)
                                    <p class="text-xs text-green-700 font-semibold">Réponse correcte</p>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('admin.reponses.show', $reponse) }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Aucune réponse pour cette question.</p>
        @endif
    </div>
</div>
@endsection
