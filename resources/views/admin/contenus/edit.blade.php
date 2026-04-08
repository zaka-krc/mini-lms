@extends('layouts.app')

@section('title', 'Éditer le contenu')
@section('page-title', 'Éditer le contenu pédagogique')

@section('content')
    <div class="max-w-3xl mx-auto">
        <form action="{{ route('admin.contenus.update', $contenu) }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="titre" class="block text-sm font-medium text-gray-800 mb-2">Titre *</label>
                <input type="text" id="titre" name="titre" value="{{ old('titre', $contenu->titre) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('titre') border-red-500 @enderror"
                    required>
                @error('titre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="sous_chapitre_id" class="block text-sm font-medium text-gray-800 mb-2">Sous-chapitre *</label>
                <select id="sous_chapitre_id" name="sous_chapitre_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sous_chapitre_id') border-red-500 @enderror"
                    required>
                    <option value="">-- Sélectionner un sous-chapitre --</option>
                    @foreach($sousChapitres as $sc)
                        <option value="{{ $sc->id }}"
                            {{ old('sous_chapitre_id', $contenu->sous_chapitre_id) == $sc->id ? 'selected' : '' }}>
                            {{ $sc->chapitre->formation->nom ?? '' }} › {{ $sc->chapitre->titre ?? '' }} › {{ $sc->titre }}
                        </option>
                    @endforeach
                </select>
                @error('sous_chapitre_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="texte" class="block text-sm font-medium text-gray-800 mb-2">Texte / Résumé du cours</label>
                <textarea id="texte" name="texte" rows="10"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono text-sm @error('texte') border-red-500 @enderror">{{ old('texte', $contenu->texte) }}</textarea>
                @error('texte') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-8">
                <label for="lien_ressource" class="block text-sm font-medium text-gray-800 mb-2">Lien ressource (optionnel)</label>
                <input type="url" id="lien_ressource" name="lien_ressource" value="{{ old('lien_ressource', $contenu->lien_ressource) }}"
                    placeholder="https://..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('lien_ressource') border-red-500 @enderror">
                @error('lien_ressource') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition font-medium">
                    <i class="fas fa-save mr-2"></i> Mettre à jour
                </button>
                <a href="{{ route('admin.contenus.show', $contenu) }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg transition font-medium text-center">
                    <i class="fas fa-times mr-2"></i> Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
