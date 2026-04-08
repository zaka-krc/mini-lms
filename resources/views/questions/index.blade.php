@extends('layouts.app')

@section('title', 'Questions')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Questions</h1>
        <a href="{{ route('admin.questions.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg flex items-center gap-2 transition">
            <i class="fas fa-plus"></i> Nouvelle Question
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
    @if ($questions->count())
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Titre</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Quiz</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Type</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700">Réponses</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($questions as $question)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ Str::limit($question->titre, 50) }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $question->quiz->titre ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-600">
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $question->type === 'multiple' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ $question->type === 'multiple' ? 'QCM' : 'Vrai/Faux' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-600">{{ $question->reponses->count() }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.questions.show', $question) }}" class="text-blue-600 hover:text-blue-800 mr-3 inline-block" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.questions.edit', $question) }}" class="text-yellow-600 hover:text-yellow-800 mr-3 inline-block" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.questions.destroy', $question) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr?');">
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
            {{ $questions->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-500 text-lg">Aucune question trouvée.</p>
            <a href="{{ route('admin.questions.create') }}" class="text-blue-600 hover:text-blue-800 mt-4 inline-block">
                Créer la première question
            </a>
        </div>
    @endif
</div>
@endsection
