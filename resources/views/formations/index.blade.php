@extends('layouts.app')

@section('title', 'Formations')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Formations</h1>
        <a href="{{ route('admin.formations.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg flex items-center gap-2 transition">
            <i class="fas fa-plus"></i> Nouvelle Formation
        </a>
    </div>

    {{-- Messages Flash --}}
    @if ($message = Session::get('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            {{ $message }}
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i>
            {{ $message }}
        </div>
    @endif

    {{-- Tableau des formations --}}
    @if ($formations->count())
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Titre</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Description</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Chapitres</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($formations as $formation)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $formation->nom }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ Str::limit($formation->description, 50) }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $formation->chapitres->count() }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.formations.show', $formation) }}" class="text-blue-600 hover:text-blue-800 mr-3 inline-block" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.formations.edit', $formation) }}" class="text-yellow-600 hover:text-yellow-800 mr-3 inline-block" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.formations.destroy', $formation) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $formations->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-500 text-lg">Aucune formation trouvée.</p>
            <a href="{{ route('admin.formations.create') }}" class="text-blue-600 hover:text-blue-800 mt-4 inline-block">
                Créer la première formation
            </a>
        </div>
    @endif
</div>
@endsection
