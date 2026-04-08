@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Tableau de bord Administrateur')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card Formations -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Formations</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $formation_count ?? 0 }}</p>
                </div>
                <i class="fas fa-book text-blue-500 text-3xl opacity-20"></i>
            </div>
            <a href="{{ route('admin.formations.index') }}" class="mt-4 text-blue-500 text-sm hover:text-blue-700">Voir tout →</a>
        </div>

        <!-- Card Chapitres -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Chapitres</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $chapitre_count ?? 0 }}</p>
                </div>
                <i class="fas fa-list text-green-500 text-3xl opacity-20"></i>
            </div>
            <a href="{{ route('admin.chapitres.index') }}" class="mt-4 text-green-500 text-sm hover:text-green-700">Voir tout →</a>
        </div>

        <!-- Card Quiz -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Quiz</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $quiz_count ?? 0 }}</p>
                </div>
                <i class="fas fa-question-circle text-purple-500 text-3xl opacity-20"></i>
            </div>
            <a href="{{ route('admin.quiz.index') }}" class="mt-4 text-purple-500 text-sm hover:text-purple-700">Voir tout →</a>
        </div>

        <!-- Card Apprenants -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Apprenants</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $user_count ?? 0 }}</p>
                </div>
                <i class="fas fa-users text-orange-500 text-3xl opacity-20"></i>
            </div>
            <a href="#" class="mt-4 text-orange-500 text-sm hover:text-orange-700">Voir tout →</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Actions rapides -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Actions rapides</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.formations.create') }}" class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                    <i class="fas fa-plus-circle text-blue-500 mr-3"></i>
                    <span class="text-blue-700">Créer une formation</span>
                </a>
                <a href="{{ route('admin.chapitres.create') }}" class="flex items-center p-3 bg-green-50 hover:bg-green-100 rounded-lg transition">
                    <i class="fas fa-plus-circle text-green-500 mr-3"></i>
                    <span class="text-green-700">Ajouter un chapitre</span>
                </a>
                <a href="{{ route('admin.quiz.create') }}" class="flex items-center p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition">
                    <i class="fas fa-plus-circle text-purple-500 mr-3"></i>
                    <span class="text-purple-700">Créer un quiz</span>
                </a>
                <a href="{{ route('admin.questions.create') }}" class="flex items-center p-3 bg-pink-50 hover:bg-pink-100 rounded-lg transition">
                    <i class="fas fa-plus-circle text-pink-500 mr-3"></i>
                    <span class="text-pink-700">Ajouter une question</span>
                </a>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Statistiques</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center border-b pb-3">
                    <span class="text-gray-600">Total contenu créé</span>
                    <span class="font-bold text-lg text-gray-800">{{ ($formation_count ?? 0) + ($chapitre_count ?? 0) + ($quiz_count ?? 0) }}</span>
                </div>
                <div class="flex justify-between items-center border-b pb-3">
                    <span class="text-gray-600">Taux de complétion moyen</span>
                    <span class="font-bold text-lg text-gray-800">--</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Dernière mise à jour</span>
                    <span class="font-bold text-lg text-gray-800">{{ now()->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
