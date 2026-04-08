@extends('layouts.app')

@section('title', 'Modifier Réponse')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Modifier Réponse</h1>
        <a href="{{ route('admin.reponses.index') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour aux réponses
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

    <form action="{{ route('admin.reponses.update', $reponse) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Question --}}
        <div>
            <label for="question_id" class="block text-gray-700 font-semibold mb-2">Question <span class="text-red-500">*</span></label>
            <select id="question_id" name="question_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('question_id') border-red-500 @enderror">
                <option value="">-- Sélectionner une question --</option>
                @foreach ($questions as $question)
                    <option value="{{ $question->id }}" {{ old('question_id', $reponse->question_id) == $question->id ? 'selected' : '' }}>
                        {{ Str::limit($question->titre, 60) }}
                    </option>
                @endforeach
            </select>
            @error('question_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Titre --}}
        <div>
            <label for="titre" class="block text-gray-700 font-semibold mb-2">Titre <span class="text-red-500">*</span></label>
            <input type="text" id="titre" name="titre" value="{{ old('titre', $reponse->titre) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('titre') border-red-500 @enderror" placeholder="Texte de la réponse...">
            @error('titre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Correcte --}}
        <div>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" id="is_correct" name="is_correct" value="1" {{ old('is_correct', $reponse->is_correct) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                <span class="text-gray-700 font-semibold">C'est la bonne réponse</span>
            </label>
            @error('is_correct')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Feedback --}}
        <div>
            <label for="feedback" class="block text-gray-700 font-semibold mb-2">Feedback</label>
            <textarea id="feedback" name="feedback" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('feedback') border-red-500 @enderror" placeholder="Commentaire pour cette réponse...">{{ old('feedback', $reponse->feedback) }}</textarea>
            @error('feedback')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Boutons --}}
        <div class="flex gap-4 pt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-save"></i> Mettre à jour
            </button>
            <a href="{{ route('admin.reponses.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-times"></i> Annuler
            </a>
        </div>
    </form>
</div>
@endsection
