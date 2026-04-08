@extends('layouts.app')

@section('title', 'Contenus pédagogiques')
@section('page-title', 'Contenus pédagogiques')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Contenus pédagogiques</h1>
        <a href="{{ route('admin.contenus.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Nouveau contenu
        </a>
    </div>

    @if($contenus->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Titre</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Sous-chapitre</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Formation</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Lien ressource</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-800">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contenus as $contenu)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-semibold text-gray-800">{{ $contenu->titre }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $contenu->sousChapitre->titre ?? '—' }}</td>
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ $contenu->sousChapitre->chapitre->formation->nom ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($contenu->lien_ressource)
                                    <a href="{{ $contenu->lien_ressource }}" target="_blank" class="text-blue-600 hover:underline truncate block max-w-xs">
                                        <i class="fas fa-external-link-alt mr-1"></i> Voir le lien
                                    </a>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.contenus.show', $contenu) }}" class="text-blue-600 hover:text-blue-700">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.contenus.edit', $contenu) }}" class="text-yellow-600 hover:text-yellow-700">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.contenus.destroy', $contenu) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce contenu ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4">{{ $contenus->links() }}</div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <i class="fas fa-file-alt text-gray-400 text-5xl mb-4"></i>
            <p class="text-gray-600 text-lg mb-6">Aucun contenu pédagogique créé</p>
            <a href="{{ route('admin.contenus.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-plus mr-2"></i> Créer le premier contenu
            </a>
        </div>
    @endif
@endsection
