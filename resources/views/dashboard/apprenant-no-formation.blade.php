@extends('layouts.app')

@section('title', 'Choisir une formation')
@section('page-title', 'Bienvenue !')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-5 flex items-start gap-3">
        <i class="fas fa-info-circle text-yellow-500 text-xl mt-0.5"></i>
        <div>
            <p class="font-semibold text-yellow-800">Vous n'êtes inscrit à aucune formation</p>
            <p class="text-yellow-700 text-sm mt-1">Choisissez une formation ci-dessous pour commencer à apprendre.</p>
        </div>
    </div>

    @if($formations->count() > 0)
        <h2 class="text-xl font-bold text-gray-800">Formations disponibles</h2>

        <div class="space-y-4">
            @foreach($formations as $formation)
                <div class="bg-white rounded-lg shadow p-5 flex items-center justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-1">
                            <h3 class="font-bold text-gray-800 text-lg">{{ $formation->nom }}</h3>
                            @if($formation->niveau)
                                <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                    {{ $formation->niveau === 'débutant' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $formation->niveau === 'intermédiaire' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $formation->niveau === 'avancé' ? 'bg-red-100 text-red-700' : '' }}">
                                    {{ ucfirst($formation->niveau) }}
                                </span>
                            @endif
                        </div>
                        @if($formation->description)
                            <p class="text-gray-500 text-sm mb-2">{{ Str::limit($formation->description, 120) }}</p>
                        @endif
                        <div class="flex gap-4 text-xs text-gray-400">
                            <span><i class="fas fa-list mr-1"></i> {{ $formation->chapitres_count }} chapitre{{ $formation->chapitres_count > 1 ? 's' : '' }}</span>
                            @if($formation->duree)
                                <span><i class="fas fa-clock mr-1"></i> {{ $formation->duree }}h</span>
                            @endif
                        </div>
                    </div>

                    <form method="POST" action="{{ route('apprenant.choisirFormation') }}">
                        @csrf
                        <input type="hidden" name="formation_id" value="{{ $formation->id }}">
                        <button type="submit"
                            class="flex-shrink-0 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg transition text-sm">
                            <i class="fas fa-user-plus mr-1"></i> S'inscrire
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
            <p class="text-gray-500">Aucune formation disponible pour l'instant.</p>
            <p class="text-gray-400 text-sm mt-2">Revenez plus tard ou contactez un administrateur.</p>
        </div>
    @endif

</div>
@endsection
