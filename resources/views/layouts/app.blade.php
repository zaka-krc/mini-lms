<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mini LMS')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white shadow-lg flex flex-col">
            <div class="p-6 border-b border-gray-700">
                <a href="{{ route('home') }}" class="text-2xl font-bold hover:text-blue-400 transition">Mini LMS</a>
            </div>

            <nav class="mt-6 flex-1">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <!-- Menu Admin -->
                        <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 transition {{ request()->routeIs('dashboard') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-home mr-3"></i> Tableau de bord
                        </a>
                        <a href="{{ route('admin.formations.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 transition {{ request()->routeIs('admin.formations.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-book mr-3"></i> Formations
                        </a>
                        <a href="{{ route('admin.chapitres.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 transition {{ request()->routeIs('admin.chapitres.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-list mr-3"></i> Chapitres
                        </a>
                        <a href="{{ route('admin.quiz.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 transition {{ request()->routeIs('admin.quiz.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-question-circle mr-3"></i> Quiz
                        </a>
                        <a href="{{ route('admin.questions.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 transition {{ request()->routeIs('admin.questions.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-edit mr-3"></i> Questions
                        </a>
                        <a href="{{ route('admin.contenus.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 transition {{ request()->routeIs('admin.contenus.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-file-alt mr-3"></i> Contenus
                        </a>
                        <a href="{{ route('admin.notes.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 transition {{ request()->routeIs('admin.notes.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-star mr-3"></i> Notes
                        </a>
                    @else
                        <!-- Menu Apprenant -->
                        <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 transition {{ request()->routeIs('dashboard') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-home mr-3"></i> Tableau de bord
                        </a>
                        <a href="{{ route('apprenant.formation.show') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 transition {{ request()->routeIs('apprenant.formation.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-book mr-3"></i> Ma Formation
                        </a>
                        <a href="{{ route('apprenant.chapitres.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 transition {{ request()->routeIs('apprenant.chapitres.*') || request()->routeIs('apprenant.chapitre.*') || request()->routeIs('apprenant.sous-chapitre.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-list mr-3"></i> Chapitres
                        </a>
                        <a href="{{ route('apprenant.notes.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 transition {{ request()->routeIs('apprenant.notes.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-chart-bar mr-3"></i> Mes Notes
                        </a>
                    @endif
                @endauth
            </nav>

            <!-- User Info Bottom -->
            <div class="p-6 bg-gray-800 border-t border-gray-700">
                @auth
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-400 capitalize">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded text-sm transition">
                            Déconnexion
                        </button>
                    </form>
                @endauth
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 px-6 py-4 shadow-sm">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Tableau de bord')</h2>
                    <div class="text-sm text-gray-500">
                        {{ now()->format('d/m/Y H:i') }}
                    </div>
                </div>
            </header>

            <!-- Alerts -->
            @if($errors->any())
                <div class="mx-6 mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                        <p class="font-semibold text-red-800">Erreurs détectées</p>
                    </div>
                    <ul class="list-disc list-inside text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="mx-6 mt-4 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Content -->
            <main class="flex-1 overflow-auto">
                <div class="p-6">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 px-6 py-4 text-center text-gray-600 text-sm">
                <p>&copy; 2026 Mini LMS. Tous droits réservés.</p>
            </footer>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
