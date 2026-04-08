@extends('layouts.app')

@section('title', $formation->nom)

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $formation->nom }}</h1>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Retour au tableau de bord
            </a>
        </div>
    </div>

    {{-- Description --}}
    <div class="mb-8 pb-8 border-b">
        <h2 class="text-lg font-semibold text-gray-800 mb-3">Description</h2>
        <p class="text-gray-600 leading-relaxed">{{ $formation->description }}</p>
    </div>

    {{-- Statistiques --}}
    <div class="grid grid-cols-3 gap-4 mb-8 py-4 border-t border-b">
        <div class="text-center">
            <p class="text-gray-600 text-sm">Chapitres</p>
            <p class="text-2xl font-bold text-blue-600">{{ $formation->chapitres->count() }}</p>
        </div>
        <div class="text-center">
            <p class="text-gray-600 text-sm">Sections</p>
            <p class="text-2xl font-bold text-blue-600">{{ $formation->chapitres->sum(fn($c) => $c->sousChapitres->count()) }}</p>
        </div>
        <div class="text-center">
            <p class="text-gray-600 text-sm">Quiz</p>
            <p class="text-2xl font-bold text-blue-600">
                {{ $formation->chapitres->sum(fn($c) => $c->sousChapitres->sum(fn($sc) => $sc->quizzes->count())) }}
            </p>
        </div>
    </div>

    {{-- Chapitres --}}
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Chapitres</h2>

        @if ($formation->chapitres->count())
            <div class="space-y-4">
                @foreach ($formation->chapitres as $chapitre)
                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-6 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $chapitre->titre }}</h3>
                                <p class="text-sm text-gray-600">{{ $chapitre->sousChapitres->count() }} sections</p>
                            </div>
                        </div>

                        {{-- Sous-chapitres --}}
                        @if ($chapitre->sousChapitres->count())
                            <div class="ml-4 space-y-2 mb-4">
                                @foreach ($chapitre->sousChapitres as $sousChapitre)
                                    <div class="flex items-center justify-between p-3 bg-white rounded border border-gray-100 hover:border-blue-300 transition">
                                        <span class="text-gray-700">{{ $sousChapitre->titre }}</span>
                                        <a href="{{ route('apprenant.sous-chapitre.show', $sousChapitre) }}" class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <a href="{{ route('apprenant.chapitre.show', $chapitre) }}" class="text-blue-600 hover:text-blue-800 font-semibold inline-block">
                            <i class="fas fa-book-open mr-2"></i>Lire le chapitre complet
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500 py-8">Aucun chapitre pour cette formation.</p>
        @endif
    </div>
</div>
@endsection
