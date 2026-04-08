@extends('layouts.app')

@section('title', 'Chapitres')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Chapitres</h1>
        <a href="#" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-filter mr-2"></i>Filtrer
        </a>
    </div>

    {{-- Liste des chapitres --}}
    @if ($chapitres->count())
        <div class="space-y-4">
            @foreach ($chapitres as $chapitre)
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg border border-blue-200 p-6 hover:shadow-lg transition">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800">{{ $chapitre->titre }}</h3>
                            <p class="text-gray-600 text-sm">Formation: <strong>{{ $chapitre->formation->titre }}</strong></p>
                        </div>
                    </div>

                    <p class="text-gray-700 mb-4">{{ Str::limit($chapitre->description, 150) }}</p>

                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            {{ $chapitre->sousChapitres->count() }} sections
                        </span>
                        <a href="{{ route('apprenant.chapitres.show', $chapitre) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                            <i class="fas fa-arrow-right mr-2"></i>Lire
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $chapitres->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-500 text-lg">Aucun chapitre trouvé.</p>
        </div>
    @endif
</div>
@endsection
