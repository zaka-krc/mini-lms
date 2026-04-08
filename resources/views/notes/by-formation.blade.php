@extends('layouts.app')

@section('title', 'Notes par Formation')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Notes par Formation</h1>
        <a href="{{ route('admin.notes.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold py-2 px-4 rounded-lg flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <form method="GET" action="{{ route('admin.notes.byFormation') }}" class="mb-6 flex gap-4">
        <select name="formation_id" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
            <option value="">-- Toutes les formations --</option>
            @foreach ($formations as $formation)
                <option value="{{ $formation->id }}" {{ request('formation_id') == $formation->id ? 'selected' : '' }}>
                    {{ $formation->nom }}
                </option>
            @endforeach
        </select>
    </form>

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
                                <a href="{{ route('admin.notes.show', $note) }}" class="text-blue-600 hover:text-blue-800 inline-block">
                                    <i class="fas fa-eye"></i>
                                </a>
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
