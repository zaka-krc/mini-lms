@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-blue-50 border border-blue-100 p-6 rounded-lg">
            <div class="text-gray-500 text-sm mb-1">Formations</div>
            <div class="text-3xl font-bold text-blue-600">{{ $stats['formations'] ?? 0 }}</div>
        </div>
        <div class="bg-green-50 border border-green-100 p-6 rounded-lg">
            <div class="text-gray-500 text-sm mb-1">Apprenants</div>
            <div class="text-3xl font-bold text-green-600">{{ $stats['apprenants'] ?? 0 }}</div>
        </div>
        <div class="bg-purple-50 border border-purple-100 p-6 rounded-lg">
            <div class="text-gray-500 text-sm mb-1">Quiz</div>
            <div class="text-3xl font-bold text-purple-600">{{ $stats['quiz'] ?? 0 }}</div>
        </div>
        <div class="bg-orange-50 border border-orange-100 p-6 rounded-lg">
            <div class="text-gray-500 text-sm mb-1">Total Utilisateurs</div>
            <div class="text-3xl font-bold text-orange-600">{{ $stats['total_users'] ?? 0 }}</div>
        </div>
    </div>

    {{-- Listes --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Formations Récentes</h2>
            <ul class="space-y-2">
                @forelse($recentFormations ?? [] as $formation)
                    <li class="p-3 bg-gray-50 rounded hover:bg-gray-100 transition">
                        <a href="{{ route('admin.formations.show', $formation->id) }}" class="text-blue-600 hover:underline font-medium">
                            {{ $formation->nom }}
                        </a>
                    </li>
                @empty
                    <li class="text-gray-500 text-sm">Aucune formation</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Utilisateurs Récents</h2>
            <ul class="space-y-2">
                @forelse($recentUsers ?? [] as $user)
                    <li class="p-3 bg-gray-50 rounded flex items-center justify-between">
                        <span class="font-medium text-gray-800">{{ $user->name }}</span>
                        <span class="px-2 py-1 text-xs rounded-full font-semibold {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $user->role }}
                        </span>
                    </li>
                @empty
                    <li class="text-gray-500 text-sm">Aucun utilisateur</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- Actions rapides --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Actions Rapides</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.formations.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg text-center font-semibold transition">
                <i class="fas fa-plus mr-2"></i>Nouvelle Formation
            </a>
            <a href="{{ route('admin.formations.index') }}" class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-lg text-center font-semibold transition">
                <i class="fas fa-list mr-2"></i>Gérer Formations
            </a>
            <a href="{{ route('admin.notes.index') }}" class="bg-purple-500 hover:bg-purple-600 text-white p-4 rounded-lg text-center font-semibold transition">
                <i class="fas fa-star mr-2"></i>Gérer Notes
            </a>
        </div>
    </div>

</div>
@endsection
