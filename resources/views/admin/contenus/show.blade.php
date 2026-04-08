@extends('layouts.app')

@section('title', $contenu->titre)
@section('page-title', 'Contenu pédagogique')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $contenu->titre }}</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $contenu->sousChapitre->chapitre->formation->nom ?? '' }}
                        › {{ $contenu->sousChapitre->chapitre->titre ?? '' }}
                        › {{ $contenu->sousChapitre->titre ?? '' }}
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.contenus.edit', $contenu) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded transition text-sm">
                        <i class="fas fa-edit"></i> Éditer
                    </a>
                    <form action="{{ route('admin.contenus.destroy', $contenu) }}" method="POST" onsubmit="return confirm('Supprimer ce contenu ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition text-sm">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>

            @if($contenu->lien_ressource)
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm font-medium text-blue-800 mb-1"><i class="fas fa-link mr-1"></i> Lien ressource</p>
                    <a href="{{ $contenu->lien_ressource }}" target="_blank" class="text-blue-600 hover:underline break-all">
                        {{ $contenu->lien_ressource }}
                    </a>
                </div>
            @endif

            @if($contenu->texte)
                <div class="prose max-w-none">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Contenu</h2>
                    <div class="bg-gray-50 rounded-lg p-4 text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $contenu->texte }}</div>
                </div>
            @else
                <p class="text-gray-400 italic">Aucun texte saisi pour ce contenu.</p>
            @endif

            <div class="mt-6 pt-4 border-t flex justify-between text-sm text-gray-500">
                <span>Créé le {{ $contenu->created_at->format('d/m/Y à H:i') }}</span>
                <a href="{{ route('admin.contenus.index') }}" class="text-blue-600 hover:underline">
                    <i class="fas fa-arrow-left mr-1"></i> Retour à la liste
                </a>
            </div>
        </div>
    </div>
@endsection
