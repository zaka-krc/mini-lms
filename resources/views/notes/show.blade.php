@extends('layouts.app')

@section('title', ($note->user->name ?? 'N/A') . ' — ' . ($note->quiz->titre ?? 'N/A'))

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $note->user->name ?? 'N/A' }}</h1>
            <p class="text-gray-600 mt-1">Quiz : <strong>{{ $note->quiz->titre ?? 'N/A' }}</strong></p>
            <a href="{{ route('admin.notes.index') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Retour aux notes
            </a>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.notes.edit', $note) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <form method="POST" action="{{ route('admin.notes.destroy', $note) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </form>
        </div>
    </div>

    {{-- Score --}}
    <div class="mb-6">
        <div class="bg-gradient-to-r {{ $note->note_sur_20 >= 10 ? 'from-green-400 to-green-600' : 'from-red-400 to-red-600' }} p-8 rounded-lg text-white text-center">
            <p class="text-lg font-semibold opacity-90 mb-2">Note obtenue</p>
            <div class="text-6xl font-bold">{{ $note->note_sur_20 }}<span class="text-3xl">/20</span></div>
            <p class="mt-4 text-lg">
                @if ($note->note_sur_20 >= 10)
                    ✓ Quiz réussi
                @else
                    ✗ Quiz échoué (note minimum : 10/20)
                @endif
            </p>
        </div>
    </div>

    {{-- Informations --}}
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-3">
        <div class="flex justify-between items-center py-2">
            <span class="text-gray-600">Apprenant :</span>
            <span class="font-semibold text-gray-900">{{ $note->user->name ?? 'N/A' }}</span>
        </div>
        <div class="flex justify-between items-center py-2 border-t">
            <span class="text-gray-600">E-mail :</span>
            <span class="font-semibold text-gray-900">{{ $note->user->email ?? 'N/A' }}</span>
        </div>
        <div class="flex justify-between items-center py-2 border-t">
            <span class="text-gray-600">Quiz :</span>
            <span class="font-semibold text-gray-900">{{ $note->quiz->titre ?? 'N/A' }}</span>
        </div>
        <div class="flex justify-between items-center py-2 border-t">
            <span class="text-gray-600">Formation :</span>
            <span class="font-semibold text-gray-900">
                {{ $note->quiz->sousChapitre->chapitre->formation->nom ?? 'N/A' }}
            </span>
        </div>
        <div class="flex justify-between items-center py-2 border-t">
            <span class="text-gray-600">Date de passage :</span>
            <span class="font-semibold text-gray-900">{{ $note->created_at->format('d/m/Y H:i') }}</span>
        </div>
    </div>
</div>
@endsection
