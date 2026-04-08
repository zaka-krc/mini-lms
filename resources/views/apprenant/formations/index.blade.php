@extends('layouts.app')

@section('title', 'Mes Formations')
@section('page-title', 'Mes Formations')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($formations as $formation)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden cursor-pointer group">
                <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-40 group-hover:from-blue-500 group-hover:to-blue-700 transition"></div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $formation->nom }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($formation->description, 80) }}</p>
                    
                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs text-gray-600">Progression</span>
                            <span class="text-xs font-bold text-blue-600">45%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: 45%"></div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                        <span><i class="fas fa-book mr-1"></i> {{ $formation->chapitres()->count() }} chapitres</span>
                        <span><i class="fas fa-clock mr-1"></i> {{ $formation->duree ?? '--' }}h</span>
                    </div>

                    <a href="{{ route('apprenant.formation.show', $formation) }}" class="block w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded text-center text-sm transition font-medium">
                        <i class="fas fa-arrow-right mr-1"></i> Continuer
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                    <p class="text-gray-600 text-lg">Aucune formation assignée</p>
                    <p class="text-gray-500 text-sm mt-2">Attendez que votre administrateur vous assigne une formation</p>
                </div>
            </div>
        @endforelse
    </div>
@endsection
