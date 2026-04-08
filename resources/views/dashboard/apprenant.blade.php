@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Infos formation --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-1">Ma Formation</h1>
        <p class="text-xl text-blue-600 font-semibold mb-4">{{ $formation->nom ?? 'N/A' }}</p>

        @if($formation)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('apprenant.formation.show') }}" class="bg-blue-50 border border-blue-100 p-5 rounded-lg hover:bg-blue-100 transition">
                    <div class="text-sm text-gray-600 font-medium mb-1">Voir ma formation</div>
                    <div class="text-xl font-bold text-blue-600">Chapitres</div>
                </a>
                <a href="{{ route('apprenant.notes.index') }}" class="bg-green-50 border border-green-100 p-5 rounded-lg hover:bg-green-100 transition">
                    <div class="text-sm text-gray-600 font-medium mb-1">Mes résultats</div>
                    <div class="text-xl font-bold text-green-600">Notes & Quiz</div>
                </a>
                <div class="bg-purple-50 border border-purple-100 p-5 rounded-lg">
                    <div class="text-sm text-gray-600 font-medium mb-2">Progression</div>
                    <div class="bg-gray-200 rounded-full h-2 mb-2">
                        <div class="bg-purple-600 h-2 rounded-full" style="width: 45%"></div>
                    </div>
                    <p class="text-purple-600 font-bold text-sm">45%</p>
                </div>
            </div>
        @endif
    </div>

    {{-- Chapitres --}}
    @if($formation)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Chapitres de la formation</h2>
            @if($formation->chapitres && $formation->chapitres->count())
                <div class="space-y-3">
                    @foreach($formation->chapitres as $chapitre)
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-blue-500 hover:bg-gray-100 transition">
                            <h3 class="font-bold text-gray-800">{{ $chapitre->titre }}</h3>
                            <p class="text-gray-500 text-sm mt-1">{{ $chapitre->sousChapitres()->count() }} sous-chapitres</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Aucun chapitre disponible pour cette formation.</p>
            @endif
        </div>
    @endif

    {{-- Infos formation (niveau, description, durée) --}}
    @if($formation)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Détails</h2>
            <div class="space-y-2 text-gray-700">
                <p><strong>Niveau :</strong> {{ $formation->niveau ?? 'N/A' }}</p>
                <p><strong>Description :</strong> {{ $formation->description ?? 'N/A' }}</p>
                @if($formation->duree)
                    <p><strong>Durée :</strong> {{ $formation->duree }} heures</p>
                @endif
            </div>
        </div>
    @else
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
            <p class="text-yellow-800">Formation non trouvée.</p>
        </div>
    @endif

</div>
@endsection
