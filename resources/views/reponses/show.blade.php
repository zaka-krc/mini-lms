@extends('layouts.app')

@section('title', $reponse->titre)

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $reponse->titre }}</h1>
            <p class="text-gray-600 mt-1">Question: <strong>{{ $reponse->question->titre ?? 'N/A' }}</strong></p>
            <a href="{{ route('admin.reponses.index') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Retour aux réponses
            </a>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.reponses.edit', $reponse) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <form method="POST" action="{{ route('admin.reponses.destroy', $reponse) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </form>
        </div>
    </div>

    {{-- Statut --}}
    <div class="mb-6 py-4 border-t border-b">
        @if ($reponse->is_correct)
            <div class="bg-green-50 p-4 rounded-lg border border-green-200 flex items-center gap-3">
                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                <div>
                    <p class="text-green-800 font-semibold">Bonne réponse</p>
                    <p class="text-green-700 text-sm">Cette réponse est marquée comme correcte</p>
                </div>
            </div>
        @else
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex items-center gap-3">
                <i class="fas fa-times-circle text-gray-400 text-2xl"></i>
                <div>
                    <p class="text-gray-800 font-semibold">Mauvaise réponse</p>
                    <p class="text-gray-600 text-sm">Cette réponse n'est pas la bonne</p>
                </div>
            </div>
        @endif
    </div>

    {{-- Feedback --}}
    @if ($reponse->feedback)
        <div>
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Feedback</h2>
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <p class="text-gray-700 leading-relaxed">{{ $reponse->feedback }}</p>
            </div>
        </div>
    @endif
</div>
@endsection
