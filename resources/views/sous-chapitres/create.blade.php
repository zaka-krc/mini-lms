@extends('layouts.app')

@section('title', 'Créer un Sous-chapitre')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Créer un Sous-chapitre</h1>
        <a href="{{ route('admin.sous-chapitres.index') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour
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

    <form action="{{ route('admin.sous-chapitres.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Chapitre --}}
        <div>
            <label for="chapitre_id" class="block text-gray-700 font-semibold mb-2">Chapitre <span class="text-red-500">*</span></label>
            <select id="chapitre_id" name="chapitre_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('chapitre_id') border-red-500 @enderror">
                <option value="">-- Sélectionner un chapitre --</option>
                @foreach ($chapitres as $chapitre)
                    <option value="{{ $chapitre->id }}" {{ old('chapitre_id') == $chapitre->id ? 'selected' : '' }}>
                        {{ $chapitre->titre }}
                    </option>
                @endforeach
            </select>
            @error('chapitre_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Titre --}}
        <div>
            <label for="titre" class="block text-gray-700 font-semibold mb-2">Titre <span class="text-red-500">*</span></label>
            <input type="text" id="titre" name="titre" value="{{ old('titre') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('titre') border-red-500 @enderror" placeholder="Ex: Les Variables">
            @error('titre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-gray-700 font-semibold mb-2">Description <span class="text-red-500">*</span></label>
            <textarea id="description" name="description" required rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror" placeholder="Brève description...">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Contenu --}}
        <div>
            <label for="contenu" class="block text-gray-700 font-semibold mb-2">Contenu <span class="text-red-500">*</span></label>
            <textarea id="contenu" name="contenu" required rows="8" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('contenu') border-red-500 @enderror" placeholder="Le contenu du sous-chapitre...">{{ old('contenu') }}</textarea>
            @error('contenu')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Ordre --}}
        <div>
            <label for="ordre" class="block text-gray-700 font-semibold mb-2">Ordre d'affichage</label>
            <input type="number" id="ordre" name="ordre" value="{{ old('ordre', 0) }}" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('ordre') border-red-500 @enderror" placeholder="0">
            @error('ordre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Boutons --}}
        <div class="flex gap-4 pt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-save"></i> Créer
            </button>
            <a href="{{ route('admin.sous-chapitres.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-times"></i> Annuler
            </a>
        </div>
    </form>
</div>
@endsection
