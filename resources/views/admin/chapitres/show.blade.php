@extends('layouts.app')

@section('title', 'Détails Chapitre')
@section('page-title', $chapitre->titre)

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">{{ $chapitre->titre }}</h1>
                        <p class="text-gray-600 mt-2">Formation: <strong>{{ $chapitre->formation->nom ?? 'N/A' }}</strong></p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.chapitres.edit', $chapitre) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded transition">
                            <i class="fas fa-edit"></i> Éditer
                        </a>
                        <form action="{{ route('admin.chapitres.destroy', $chapitre) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Contenu</h3>
                    <div class="text-gray-700 leading-relaxed">
                        {!! nl2br(e($chapitre->contenu)) !!}
                    </div>
                </div>
            </div>

            <!-- Sous-chapitres -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Sous-chapitres</h2>
                    <a href="{{ route('admin.sous-chapitres.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition text-sm">
                        <i class="fas fa-plus mr-1"></i> Ajouter un sous-chapitre
                    </a>
                </div>

                @if($chapitre->sousChapitres()->count() > 0)
                    <div class="space-y-3">
                        @foreach($chapitre->sousChapitres as $sousChapitre)
                            <div class="p-4 border border-gray-200 rounded-lg hover:border-blue-300 transition">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-800">{{ $sousChapitre->titre }}</h4>
                                        <p class="text-gray-600 text-sm mt-1">{{ Str::limit($sousChapitre->contenu, 80) }}</p>
                                    </div>
                                    <div class="flex gap-2 ml-4">
                                        <a href="{{ route('admin.sous-chapitres.edit', $sousChapitre) }}" class="text-yellow-600 hover:text-yellow-700">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.sous-chapitres.destroy', $sousChapitre) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Aucun sous-chapitre pour ce chapitre</p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="bg-white rounded-lg shadow p-6 h-fit">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Informations</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-600">Ordre d'affichage</p>
                    <p class="text-lg font-bold text-gray-800">{{ $chapitre->ordre }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Sous-chapitres</p>
                    <p class="text-lg font-bold text-gray-800">{{ $chapitre->sousChapitres()->count() }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Créé le</p>
                    <p class="text-sm font-bold text-gray-800">{{ $chapitre->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Dernière modification</p>
                    <p class="text-sm font-bold text-gray-800">{{ $chapitre->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
