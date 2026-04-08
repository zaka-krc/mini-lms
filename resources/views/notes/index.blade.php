@extends('layouts.app')

@section('title', 'Notes')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Notes</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.notes.byFormation') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-chart-bar"></i> Par Formation
            </a>
            <a href="{{ route('admin.notes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Nouvelle Note
            </a>
        </div>
    </div>

    @if ($notes->count())
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Apprenant</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Quiz</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700">Note</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700">Statut</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700">Date</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($notes as $note)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $note->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $note->quiz->titre ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-lg font-bold {{ $note->note_sur_20 >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $note->note_sur_20 }}/20
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($note->note_sur_20 >= 10)
                                    <span class="px-3 py-1 rounded text-xs font-semibold bg-green-100 text-green-800">Réussi</span>
                                @else
                                    <span class="px-3 py-1 rounded text-xs font-semibold bg-red-100 text-red-800">Échoué</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-gray-600">{{ $note->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.notes.show', $note) }}" class="text-blue-600 hover:text-blue-800 mr-3 inline-block" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.notes.edit', $note) }}" class="text-yellow-600 hover:text-yellow-800 mr-3 inline-block" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.notes.destroy', $note) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr?');">
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
        <div class="mt-6">{{ $notes->links() }}</div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-500 text-lg">Aucune note trouvée.</p>
        </div>
    @endif
</div>
@endsection
