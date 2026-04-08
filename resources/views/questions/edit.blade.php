@extends('layouts.app')

@section('title', 'Modifier Question')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Modifier Question</h1>
        <a href="{{ route('admin.questions.index') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour aux questions
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

    <form action="{{ route('admin.questions.update', $question) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Quiz --}}
        <div>
            <label for="quiz_id" class="block text-gray-700 font-semibold mb-2">Quiz <span class="text-red-500">*</span></label>
            <select id="quiz_id" name="quiz_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('quiz_id') border-red-500 @enderror">
                <option value="">-- Sélectionner un quiz --</option>
                @foreach ($quizzes as $quiz)
                    <option value="{{ $quiz->id }}" {{ old('quiz_id', $question->quiz_id) == $quiz->id ? 'selected' : '' }}>
                        {{ $quiz->titre }}
                    </option>
                @endforeach
            </select>
            @error('quiz_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Titre --}}
        <div>
            <label for="titre" class="block text-gray-700 font-semibold mb-2">Titre <span class="text-red-500">*</span></label>
            <input type="text" id="titre" name="titre" value="{{ old('titre', $question->titre) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('titre') border-red-500 @enderror" placeholder="Posez votre question...">
            @error('titre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Type --}}
        <div>
            <label for="type" class="block text-gray-700 font-semibold mb-2">Type <span class="text-red-500">*</span></label>
            <select id="type" name="type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('type') border-red-500 @enderror">
                <option value="multiple" {{ old('type', $question->type) === 'multiple' ? 'selected' : '' }}>QCM (Choix multiples)</option>
                <option value="vrai_faux" {{ old('type', $question->type) === 'vrai_faux' ? 'selected' : '' }}>Vrai/Faux</option>
            </select>
            @error('type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Explication --}}
        <div>
            <label for="explication" class="block text-gray-700 font-semibold mb-2">Explication</label>
            <textarea id="explication" name="explication" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('explication') border-red-500 @enderror" placeholder="Explication de la bonne réponse...">{{ old('explication', $question->explication) }}</textarea>
            @error('explication')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Points --}}
        <div>
            <label for="points" class="block text-gray-700 font-semibold mb-2">Points</label>
            <input type="number" id="points" name="points" value="{{ old('points', $question->points ?? 1) }}" min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('points') border-red-500 @enderror" placeholder="1">
            @error('points')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Boutons --}}
        <div class="flex gap-4 pt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-save"></i> Mettre à jour
            </button>
            <a href="{{ route('admin.questions.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-times"></i> Annuler
            </a>
        </div>
    </form>
</div>
@endsection
