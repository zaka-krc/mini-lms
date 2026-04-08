@extends('layouts.app')

@section('title', 'Mes Notes')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mes Notes et Résultats</h1>
        <p class="text-gray-600 mt-1">Suivi de votre progression</p>
    </div>

    {{-- Statistiques --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <p class="text-gray-600 text-sm">Moyenne générale</p>
            <p class="text-3xl font-bold text-blue-600 mt-2">
                {{ $notes->count() ? number_format($notes->avg('note_sur_20'), 1) : '—' }}/20
            </p>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <p class="text-gray-600 text-sm">Quiz réussis</p>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ $notes->where('note_sur_20', '>=', 10)->count() }}</p>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-lg p-6">
            <p class="text-gray-600 text-sm">Quiz échoués</p>
            <p class="text-3xl font-bold text-red-600 mt-2">{{ $notes->where('note_sur_20', '<', 10)->count() }}</p>
        </div>
        <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
            <p class="text-gray-600 text-sm">Total passés</p>
            <p class="text-3xl font-bold text-purple-600 mt-2">{{ $notes->count() }}</p>
        </div>
    </div>

    {{-- Tableau --}}
    @if ($notes->count())
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Quiz</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Section</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700">Note</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700">Statut</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($notes as $note)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $note->quiz->titre ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $note->quiz->sousChapitre->titre ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <span class="text-lg font-bold {{ $note->note_sur_20 >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $note->note_sur_20 }}/20
                                    </span>
                                    <div class="w-16 bg-gray-200 rounded-full h-1.5">
                                        <div class="{{ $note->note_sur_20 >= 10 ? 'bg-green-500' : 'bg-red-500' }} h-1.5 rounded-full"
                                             style="width: {{ ($note->note_sur_20 / 20) * 100 }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($note->note_sur_20 >= 10)
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i>Réussi
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        <i class="fas fa-times mr-1"></i>Échoué
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $note->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $notes->links() }}</div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-500 text-lg">Aucune note enregistrée</p>
            <p class="text-gray-400 mt-2">Complétez des quiz pour voir vos résultats ici</p>
        </div>
    @endif
</div>
@endsection
