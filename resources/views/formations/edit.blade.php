@extends('layouts.app')

@section('title', 'Modifier Formation')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Modifier Formation</h1>
        <a href="{{ route('admin.formations.index') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour aux formations
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

    <form action="{{ route('admin.formations.update', $formation) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Nom --}}
        <div>
            <label for="nom" class="block text-gray-700 font-semibold mb-2">Nom de la formation <span class="text-red-500">*</span></label>
            <input type="text" id="nom" name="nom" value="{{ old('nom', $formation->nom) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nom') border-red-500 @enderror" placeholder="Ex: Introduction à Laravel">
            @error('nom')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-gray-700 font-semibold mb-2">Description <span class="text-red-500">*</span></label>
            <textarea id="description" name="description" required rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror" placeholder="Décrivez le contenu de la formation...">{{ old('description', $formation->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Niveau --}}
        <div>
            <label for="niveau" class="block text-gray-700 font-semibold mb-2">Niveau <span class="text-red-500">*</span></label>
            <select id="niveau" name="niveau" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('niveau') border-red-500 @enderror">
                <option value="">-- Sélectionnez un niveau --</option>
                <option value="débutant" {{ old('niveau', $formation->niveau) === 'débutant' ? 'selected' : '' }}>Débutant</option>
                <option value="intermédiaire" {{ old('niveau', $formation->niveau) === 'intermédiaire' ? 'selected' : '' }}>Intermédiaire</option>
                <option value="avancé" {{ old('niveau', $formation->niveau) === 'avancé' ? 'selected' : '' }}>Avancé</option>
            </select>
            @error('niveau')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Durée --}}
        <div>
            <label for="duree" class="block text-gray-700 font-semibold mb-2">Durée (en heures) <span class="text-red-500">*</span></label>
            <input type="number" id="duree" name="duree" value="{{ old('duree', $formation->duree) }}" required min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('duree') border-red-500 @enderror" placeholder="Ex: 20">
            @error('duree')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Boutons --}}
        <div class="flex gap-4 pt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-save"></i> Mettre à jour
            </button>
            <a href="{{ route('admin.formations.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-times"></i> Annuler
            </a>
        </div>
    </form>
</div>
@endsection
