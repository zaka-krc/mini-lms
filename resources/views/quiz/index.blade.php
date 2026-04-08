@extends('layouts.app')

@section('title', 'Quiz')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Quiz</h1>
        <a href="{{ route('admin.quiz.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg flex items-center gap-2 transition">
            <i class="fas fa-plus"></i> Nouveau Quiz
        </a>
    </div>

    {{-- Messages Flash --}}
    @if ($message = Session::get('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            {{ $message }}
        </div>
    @endif

    {{-- Tableau --}}
    @if ($quizzes->count())
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Titre</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Chapitre</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700">Questions</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($quizzes as $quiz)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $quiz->titre }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $quiz->sousChapitre->titre ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-center text-gray-600">{{ $quiz->questions->count() }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.quiz.show', $quiz) }}" class="text-blue-600 hover:text-blue-800 mr-3 inline-block" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.quiz.edit', $quiz) }}" class="text-yellow-600 hover:text-yellow-800 mr-3 inline-block" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.quiz.destroy', $quiz) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $quizzes->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-500 text-lg">Aucun quiz trouvé.</p>
            <a href="{{ route('admin.quiz.create') }}" class="text-blue-600 hover:text-blue-800 mt-4 inline-block">
                Créer le premier quiz
            </a>
        </div>
    @endif
</div>
@endsection
