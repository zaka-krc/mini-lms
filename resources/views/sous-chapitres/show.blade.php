@extends('layouts.app')

@section('title', $sousChapitre->titre)

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $sousChapitre->titre }}</h1>
            <p class="text-gray-600 mt-1">Chapitre: <strong>{{ $sousChapitre->chapitre->titre ?? 'N/A' }}</strong></p>
            <a href="{{ route('admin.sous-chapitres.index') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.sous-chapitres.edit', $sousChapitre) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <form method="POST" action="{{ route('admin.sous-chapitres.destroy', $sousChapitre) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </form>
        </div>
    </div>

    {{-- Description --}}
    <div class="mb-8 pb-8 border-b">
        <h2 class="text-xl font-semibold text-gray-800 mb-3">Description</h2>
        <p class="text-gray-600 leading-relaxed">{{ $sousChapitre->description }}</p>
    </div>

    {{-- Contenu --}}
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Contenu</h2>
        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 text-gray-700 leading-relaxed">
            {!! nl2br(e($sousChapitre->contenu)) !!}
        </div>
    </div>
</div>
@endsection
