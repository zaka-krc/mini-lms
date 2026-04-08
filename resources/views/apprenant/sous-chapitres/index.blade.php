@extends('layouts.app')

@section('title', 'Sections')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Sections à étudier</h1>
    </div>

    {{-- Liste des sous-chapitres --}}
    @if ($sousChapitres->count())
        <div class="space-y-4">
            @foreach ($sousChapitres as $sousChapitre)
                <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg border border-purple-200 p-6 hover:shadow-lg transition">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $sousChapitre->titre }}</h3>
                            <p class="text-gray-600 text-sm">Chapitre: <strong>{{ $sousChapitre->chapitre->titre }}</strong></p>
                        </div>
                    </div>

                    <p class="text-gray-700 mb-4">{{ Str::limit($sousChapitre->description, 150) }}</p>

                    <div class="flex items-center justify-between">
                        @if ($sousChapitre->quizzes->count())
                            <span class="text-sm text-gray-600">
                                <i class="fas fa-question-circle mr-2 text-orange-500"></i>
                                {{ $sousChapitre->quizzes->count() }} quiz disponible(s)
                            </span>
                        @else
                            <span class="text-sm text-gray-600">
                                <i class="fas fa-info-circle mr-2 text-gray-400"></i>
                                Pas de quiz
                            </span>
                        @endif
                        <a href="{{ route('apprenant.sous-chapitres.show', $sousChapitre) }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                            <i class="fas fa-arrow-right mr-2"></i>Lire
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $sousChapitres->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-500 text-lg">Aucune section trouvée.</p>
        </div>
    @endif
</div>
@endsection
