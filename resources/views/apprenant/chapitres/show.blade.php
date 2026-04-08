@extends('layouts.app')

@section('title', $chapitre->titre)
@section('page-title', $chapitre->titre)

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Contenu principal -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-lg shadow p-8">
                <!-- Chapeau de navigation -->
                <div class="mb-6 pb-6 border-b">
                    <a href="{{ route('apprenant.formation.show') }}" class="text-blue-600 hover:text-blue-700 text-sm">
                        <i class="fas fa-arrow-left mr-2"></i> Retour à {{ $chapitre->formation->nom }}
                    </a>
                </div>

                <!-- Titre et contenu -->
                <h1 class="text-4xl font-bold text-gray-800 mb-6">{{ $chapitre->titre }}</h1>
                
                <div class="text-gray-700 leading-relaxed mb-8">
                    {!! nl2br(e($chapitre->description)) !!}
                </div>

                <!-- Sous-chapitres -->
                @if($chapitre->sousChapitres()->count() > 0)
                    <div class="mt-12 pt-8 border-t">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Sections</h2>
                        <div class="space-y-4">
                            @foreach($chapitre->sousChapitres as $sousChapitre)
                                <a href="{{ route('apprenant.sous-chapitre.show', $sousChapitre) }}" class="block p-5 bg-gray-50 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition group">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="font-semibold text-gray-800 group-hover:text-blue-700 mb-1">{{ $sousChapitre->titre }}</h3>
                                            <p class="text-gray-600 text-sm">{{ Str::limit($sousChapitre->contenu, 150) }}</p>
                                        </div>
                                        <i class="fas fa-arrow-right text-blue-400 ml-4 group-hover:translate-x-1 transition"></i>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Navigation entre chapitres -->
                <div class="mt-12 pt-8 border-t flex justify-between">
                    @if($previousChapitre = $chapitre->formation->chapitres()->where('ordre', '<', $chapitre->ordre)->orderBy('ordre', 'desc')->first())
                        <a href="{{ route('apprenant.chapitre.show', $previousChapitre) }}" class="flex items-center text-blue-600 hover:text-blue-700 font-medium">
                            <i class="fas fa-arrow-left mr-2"></i> Chapitre précédent
                        </a>
                    @else
                        <div></div>
                    @endif

                    @if($nextChapitre = $chapitre->formation->chapitres()->where('ordre', '>', $chapitre->ordre)->orderBy('ordre', 'asc')->first())
                        <a href="{{ route('apprenant.chapitre.show', $nextChapitre) }}" class="flex items-center text-blue-600 hover:text-blue-700 font-medium">
                            Chapitre suivant <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @else
                        <div></div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar - Chapitres de la formation -->
        <div class="bg-white rounded-lg shadow p-6 h-fit sticky top-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Plan de cours</h3>
            
            <div class="space-y-2">
                @foreach($chapitre->formation->chapitres as $c)
                    <a 
                        href="{{ route('apprenant.chapitre.show', $c) }}" 
                        class="block p-3 rounded-lg transition {{ $c->id === $chapitre->id ? 'bg-blue-100 border-l-4 border-blue-500 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                        <div class="flex items-start">
                            <span class="text-sm">{{ $c->titre }}</span>
                            @if($c->id === $chapitre->id)
                                <i class="fas fa-check ml-2 text-blue-600"></i>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Quiz de ce chapitre -->
            @php $chapitreQuizzes = $chapitre->sousChapitres->flatMap(fn($sc) => $sc->quizzes)->unique('id'); @endphp
            @if($chapitreQuizzes->count() > 0)
                <div class="mt-6 pt-6 border-t">
                    <h4 class="font-bold text-gray-800 mb-3 text-sm">Quiz disponibles</h4>
                    <div class="space-y-2">
                        @foreach($chapitreQuizzes as $q)
                            <a href="{{ route('apprenant.quiz.show', $q) }}" class="block p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition text-sm">
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-purple-700">{{ Str::limit($q->titre, 20) }}</span>
                                    <i class="fas fa-arrow-right text-purple-600"></i>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Marquer comme complété -->
            <button class="w-full mt-6 bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg transition font-medium text-sm">
                <i class="fas fa-check mr-2"></i> Marquer comme complété
            </button>
        </div>
    </div>
@endsection
