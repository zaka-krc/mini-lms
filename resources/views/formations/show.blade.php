@extends('layouts.app')

@section('title', $formation->nom)

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $formation->nom }}</h1>
            <a href="{{ route('admin.formations.index') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Retour aux formations
            </a>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.formations.edit', $formation) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <form method="POST" action="{{ route('admin.formations.destroy', $formation) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette formation?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </form>
        </div>
    </div>

    {{-- Messages Flash --}}
    @if ($message = Session::get('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            {{ $message }}
        </div>
    @endif

    {{-- Description --}}
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-2">Description</h2>
        <p class="text-gray-600 leading-relaxed">{{ $formation->description }}</p>
    </div>

    {{-- Informations --}}
    <div class="grid grid-cols-3 gap-4 mb-6 py-4 border-t border-b">
        <div class="text-center">
            <p class="text-gray-600 text-sm">Chapitres</p>
            <p class="text-2xl font-bold text-blue-600">{{ $formation->chapitres->count() }}</p>
        </div>
        <div class="text-center">
            <p class="text-gray-600 text-sm">Sous-chapitres</p>
            <p class="text-2xl font-bold text-blue-600">{{ $formation->chapitres->sum(fn($c) => $c->sousChapitres->count()) }}</p>
        </div>
        <div class="text-center">
            <p class="text-gray-600 text-sm">Créée le</p>
            <p class="text-lg font-semibold text-gray-700">{{ $formation->created_at->format('d/m/Y') }}</p>
        </div>
    </div>

    {{-- Chapitres --}}
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Chapitres</h2>
            <a href="{{ route('admin.chapitres.create', ['formation_id' => $formation->id]) }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Ajouter Chapitre
            </a>
        </div>

        @if ($formation->chapitres->count())
            <div class="space-y-3">
                @foreach ($formation->chapitres as $chapitre)
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 hover:border-blue-400 transition">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">{{ $chapitre->titre }}</h3>
                                <p class="text-sm text-gray-600">{{ $chapitre->sousChapitres->count() }} sous-chapitres</p>
                            </div>
                            <a href="{{ route('admin.chapitres.show', $chapitre) }}" class="text-blue-600 hover:text-blue-800 mr-3 inline-block">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Aucun chapitre pour cette formation.</p>
        @endif
    </div>

    {{-- Gestion des apprenants --}}
    <div class="border-t pt-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Apprenants inscrits ({{ $formation->users->count() }})</h2>

        @if ($formation->users->count())
            <div class="space-y-2 mb-6">
                @foreach ($formation->users as $apprenant)
                    <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg border border-gray-200">
                        <div>
                            <span class="font-medium text-gray-800">{{ $apprenant->name }}</span>
                            <span class="text-sm text-gray-500 ml-2">{{ $apprenant->email }}</span>
                        </div>
                        <form method="POST" action="{{ route('admin.formations.retirerApprenant', [$formation, $apprenant]) }}" onsubmit="return confirm('Retirer cet apprenant de la formation ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                                <i class="fas fa-user-minus mr-1"></i> Retirer
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 mb-4">Aucun apprenant inscrit.</p>
        @endif

        @if ($apprenantsSansFormation->count() > 0)
            <form method="POST" action="{{ route('admin.formations.assignApprenant', $formation) }}" class="flex gap-3 items-end">
                @csrf
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Inscrire un apprenant</label>
                    <select name="user_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Choisir un apprenant --</option>
                        @foreach ($apprenantsSansFormation as $apprenant)
                            <option value="{{ $apprenant->id }}">{{ $apprenant->name }} ({{ $apprenant->email }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-user-plus"></i> Inscrire
                </button>
            </form>
        @endif
    </div>
</div>
@endsection
