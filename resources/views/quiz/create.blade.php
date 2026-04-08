@extends('layouts.app')

@section('title', 'Créer un Quiz')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Créer un Quiz</h1>
        <a href="{{ route('admin.quiz.index') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour aux quiz
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <h3 class="text-red-800 font-semibold mb-2 flex items-center gap-2">
                <i class="fas fa-exclamation-triangle"></i>Erreurs de validation
            </h3>
            <ul class="text-red-700 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.quiz.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Sous-chapitre --}}
        <div>
            <label for="sous_chapitre_id" class="block text-gray-700 font-semibold mb-2">Sous-chapitre <span class="text-red-500">*</span></label>
            <select id="sous_chapitre_id" name="sous_chapitre_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sous_chapitre_id') border-red-500 @enderror">
                <option value="">-- Sélectionner un sous-chapitre --</option>
                @foreach ($sousChapitres as $sousChapitre)
                    <option value="{{ $sousChapitre->id }}" {{ old('sous_chapitre_id') == $sousChapitre->id ? 'selected' : '' }}>
                        {{ $sousChapitre->titre }}
                    </option>
                @endforeach
            </select>
            @error('sous_chapitre_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Titre --}}
        <div>
            <label for="titre" class="block text-gray-700 font-semibold mb-2">Titre <span class="text-red-500">*</span></label>
            <input type="text" id="titre" name="titre" value="{{ old('titre') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('titre') border-red-500 @enderror" placeholder="Ex: Quiz Chapitre 1">
            @error('titre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea id="description" name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror" placeholder="Description du quiz...">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Temps limite --}}
        <div>
            <label for="temps_limite" class="block text-gray-700 font-semibold mb-2">Temps limite (minutes)</label>
            <input type="number" id="temps_limite" name="temps_limite" value="{{ old('temps_limite', 30) }}" min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('temps_limite') border-red-500 @enderror" placeholder="30">
            @error('temps_limite')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Note minimale --}}
        <div>
            <label for="note_minimale" class="block text-gray-700 font-semibold mb-2">Note minimale pour réussir (%)</label>
            <input type="number" id="note_minimale" name="note_minimale" value="{{ old('note_minimale', 50) }}" min="0" max="100" step="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('note_minimale') border-red-500 @enderror" placeholder="50">
            @error('note_minimale')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Boutons --}}
        <div class="flex gap-4 pt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-save"></i> Créer
            </button>
            <a href="{{ route('admin.quiz.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-times"></i> Annuler
            </a>
        </div>
    </form>
</div>
@endsection
