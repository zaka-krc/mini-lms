@extends('layouts.app')

@section('title', 'Modifier Chapitre')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Modifier Chapitre</h1>
        <a href="{{ route('admin.chapitres.index') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour aux chapitres
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

    <form action="{{ route('admin.chapitres.update', $chapitre) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Formation --}}
        <div>
            <label for="formation_id" class="block text-gray-700 font-semibold mb-2">Formation <span class="text-red-500">*</span></label>
            <select id="formation_id" name="formation_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('formation_id') border-red-500 @enderror">
                <option value="">-- Sélectionner une formation --</option>
                @foreach ($formations as $formation)
                    <option value="{{ $formation->id }}" {{ old('formation_id', $chapitre->formation_id) == $formation->id ? 'selected' : '' }}>
                        {{ $formation->nom }}
                    </option>
                @endforeach
            </select>
            @error('formation_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Titre --}}
        <div>
            <label for="titre" class="block text-gray-700 font-semibold mb-2">Titre <span class="text-red-500">*</span></label>
            <input type="text" id="titre" name="titre" value="{{ old('titre', $chapitre->titre) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('titre') border-red-500 @enderror" placeholder="Ex: Introduction aux Bases">
            @error('titre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-gray-700 font-semibold mb-2">Description <span class="text-red-500">*</span></label>
            <textarea id="description" name="description" required rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror" placeholder="Décrivez le chapitre...">{{ old('description', $chapitre->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Contenu --}}
        <div>
            <label for="contenu" class="block text-gray-700 font-semibold mb-2">Contenu <span class="text-red-500">*</span></label>
            <textarea id="contenu" name="contenu" required rows="8" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('contenu') border-red-500 @enderror" placeholder="Le contenu du chapitre...">{{ old('contenu', $chapitre->contenu) }}</textarea>
            @error('contenu')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Boutons --}}
        <div class="flex gap-4 pt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-save"></i> Mettre à jour
            </button>
            <a href="{{ route('admin.chapitres.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-times"></i> Annuler
            </a>
        </div>
    </form>
</div>
@endsection
