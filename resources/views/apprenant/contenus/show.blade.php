@extends('layouts.app')

@section('title', $contenu->titre)
@section('page-title', $contenu->titre)

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Fil d'Ariane -->
        <div class="text-sm text-gray-500">
            {{ $contenu->sousChapitre->chapitre->formation->nom ?? '' }}
            › {{ $contenu->sousChapitre->chapitre->titre ?? '' }}
            › <span class="font-medium text-gray-700">{{ $contenu->sousChapitre->titre ?? '' }}</span>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $contenu->titre }}</h1>

            @if($contenu->lien_ressource)
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm font-medium text-blue-800 mb-1"><i class="fas fa-external-link-alt mr-1"></i> Ressource complémentaire</p>
                    <a href="{{ $contenu->lien_ressource }}" target="_blank" class="text-blue-600 hover:underline">
                        {{ $contenu->lien_ressource }}
                    </a>
                </div>
            @endif

            @if($contenu->texte)
                <div class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $contenu->texte }}</div>
            @else
                <p class="text-gray-400 italic">Aucun texte disponible pour ce contenu.</p>
            @endif
        </div>

        <div class="flex justify-between">
            <a href="{{ route('apprenant.sous-chapitre.show', $contenu->sousChapitre) }}" class="text-blue-600 hover:underline text-sm">
                <i class="fas fa-arrow-left mr-1"></i> Retour au sous-chapitre
            </a>
        </div>
    </div>
@endsection
