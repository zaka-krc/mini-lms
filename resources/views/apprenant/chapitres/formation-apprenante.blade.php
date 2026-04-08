@extends('layouts.app')

@section('title', 'Chapitres - ' . $formation->nom)
@section('page-title', $formation->nom)

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="mb-6 pb-6 border-b flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $formation->nom }}</h1>
            <p class="text-gray-500 mt-1">{{ $chapitres->total() }} chapitre(s)</p>
        </div>
        <a href="{{ route('apprenant.formation.show') }}" class="text-blue-600 hover:text-blue-800 text-sm">
            <i class="fas fa-arrow-left mr-2"></i>Retour à ma formation
        </a>
    </div>

    @if($chapitres->count() > 0)
        <div class="space-y-4">
            @foreach($chapitres as $index => $chapitre)
                <a href="{{ route('apprenant.chapitre.show', $chapitre) }}"
                   class="block p-5 border border-gray-200 rounded-lg hover:border-blue-400 hover:bg-blue-50 transition group">
                    <div class="flex items-center justify-between">
                        <div class="flex items-start gap-4">
                            <span class="flex-shrink-0 w-9 h-9 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-sm">
                                {{ $chapitres->firstItem() + $index }}
                            </span>
                            <div>
                                <h3 class="font-semibold text-gray-800 group-hover:text-blue-700">{{ $chapitre->titre }}</h3>
                                <p class="text-gray-500 text-sm mt-1">{{ Str::limit($chapitre->contenu, 100) }}</p>
                                <p class="text-xs text-gray-400 mt-1">
                                    <i class="fas fa-list mr-1"></i>{{ $chapitre->sousChapitres->count() }} section(s)
                                </p>
                            </div>
                        </div>
                        <i class="fas fa-arrow-right text-blue-400 group-hover:translate-x-1 transition"></i>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $chapitres->links() }}
        </div>
    @else
        <p class="text-gray-500 text-center py-12">Aucun chapitre disponible pour cette formation.</p>
    @endif
</div>
@endsection
