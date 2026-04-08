<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini LMS – Plateforme pédagogique</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-gray-900 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-white text-lg"></i>
                </div>
                <h1 class="text-2xl font-bold">Mini LMS</h1>
            </div>
            <div class="flex gap-3 items-center">
                @auth
                    <span class="text-gray-400 text-sm">{{ auth()->user()->name }}</span>
                    <a href="{{ route('dashboard') }}" class="px-5 py-2 text-sm font-medium bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                        <i class="fas fa-home mr-1"></i> Mon espace
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-5 py-2 text-sm font-medium text-gray-200 hover:text-white border border-gray-600 hover:border-red-500 hover:text-red-400 rounded-lg transition">
                            <i class="fas fa-sign-out-alt mr-1"></i> Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-medium text-gray-200 hover:text-white border border-gray-600 hover:border-gray-400 rounded-lg transition">
                        Se connecter
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-medium bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                        S'inscrire
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section style="background: linear-gradient(135deg, #111827 0%, #1e3a5f 100%);" class="text-white py-20">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-4 text-white">Apprenez à votre rythme</h2>
            <p class="text-lg mb-8 max-w-xl mx-auto" style="color: #d1d5db;">
                Accédez à vos formations, suivez vos chapitres, répondez aux quiz et consultez vos résultats — tout en un seul endroit.
            </p>
            @guest
                <a href="{{ route('register') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold px-8 py-3 rounded-lg transition text-lg">
                    <i class="fas fa-rocket mr-2"></i> Commencer maintenant
                </a>
            @endguest
        </div>
    </section>

    <!-- Stats -->
    <section class="bg-white border-b py-8">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-3 gap-6 text-center">
                <div>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['formations'] }}</p>
                    <p class="text-gray-500 text-sm mt-1"><i class="fas fa-book mr-1"></i> Formation{{ $stats['formations'] > 1 ? 's' : '' }}</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['apprenants'] }}</p>
                    <p class="text-gray-500 text-sm mt-1"><i class="fas fa-users mr-1"></i> Apprenant{{ $stats['apprenants'] > 1 ? 's' : '' }}</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-purple-600">{{ $stats['quiz'] }}</p>
                    <p class="text-gray-500 text-sm mt-1"><i class="fas fa-question-circle mr-1"></i> Quiz disponibles</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Formations disponibles -->
    <section class="py-12 flex-1">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                <i class="fas fa-book-open text-blue-500 mr-2"></i> Formations disponibles
            </h2>

            @if($formations->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($formations as $formation)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                            <div class="h-3 bg-gradient-to-r from-blue-400 to-blue-600"></div>
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-3">
                                    <h3 class="text-lg font-bold text-gray-800">{{ $formation->nom }}</h3>
                                    @if($formation->niveau)
                                        <span class="ml-2 flex-shrink-0 text-xs px-2 py-1 rounded-full font-medium
                                            {{ $formation->niveau === 'débutant' ? 'bg-green-100 text-green-700' : '' }}
                                            {{ $formation->niveau === 'intermédiaire' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                            {{ $formation->niveau === 'avancé' ? 'bg-red-100 text-red-700' : '' }}">
                                            {{ ucfirst($formation->niveau) }}
                                        </span>
                                    @endif
                                </div>

                                @if($formation->description)
                                    <p class="text-gray-500 text-sm mb-4 leading-relaxed">
                                        {{ Str::limit($formation->description, 100) }}
                                    </p>
                                @endif

                                <div class="flex items-center gap-4 text-xs text-gray-400 border-t pt-3">
                                    <span><i class="fas fa-list mr-1"></i> {{ $formation->chapitres_count }} chapitre{{ $formation->chapitres_count > 1 ? 's' : '' }}</span>
                                    @if($formation->duree)
                                        <span><i class="fas fa-clock mr-1"></i> {{ $formation->duree }}h</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                    <p class="text-gray-500">Aucune formation disponible pour l'instant.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Fonctionnalités -->
    <section class="bg-white border-t py-12">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Ce que vous pouvez faire</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-6">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-book text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Suivre des formations</h3>
                    <p class="text-gray-500 text-sm">Accédez à vos chapitres et sous-chapitres avec du contenu pédagogique structuré.</p>
                </div>
                <div class="text-center p-6">
                    <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-question-circle text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Répondre aux quiz</h3>
                    <p class="text-gray-500 text-sm">Testez vos connaissances avec des quiz à choix multiple et obtenez votre score automatiquement.</p>
                </div>
                <div class="text-center p-6">
                    <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-bar text-green-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Consulter vos notes</h3>
                    <p class="text-gray-500 text-sm">Suivez votre progression et consultez l'historique de vos résultats.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 text-center text-sm py-5">
        &copy; {{ date('Y') }} Mini LMS — Plateforme pédagogique Laravel
    </footer>

</body>
</html>
