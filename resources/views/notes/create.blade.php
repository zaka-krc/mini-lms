@extends('layouts.app')

@section('title', 'Créer une Note')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Créer une Note</h1>
        <a href="{{ route('admin.notes.index') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour aux notes
        </a>
    </div>

    <form action="{{ route('admin.notes.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Apprenant --}}
        <div>
            <label for="user_id" class="block text-gray-700 font-semibold mb-2">Apprenant <span class="text-red-500">*</span></label>
            <select id="user_id" name="user_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-500 @enderror">
                <option value="">-- Sélectionner un apprenant --</option>
                @foreach ($apprenants as $apprenant)
                    <option value="{{ $apprenant->id }}" {{ old('user_id') == $apprenant->id ? 'selected' : '' }}>
                        {{ $apprenant->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Quiz --}}
        <div>
            <label for="quiz_id" class="block text-gray-700 font-semibold mb-2">Quiz <span class="text-red-500">*</span></label>
            <select id="quiz_id" name="quiz_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('quiz_id') border-red-500 @enderror">
                <option value="">-- Sélectionner un quiz --</option>
                @foreach ($quizzes as $quiz)
                    <option value="{{ $quiz->id }}" {{ old('quiz_id') == $quiz->id ? 'selected' : '' }}>
                        {{ $quiz->titre }} ({{ $quiz->sousChapitre->titre ?? 'N/A' }})
                    </option>
                @endforeach
            </select>
            @error('quiz_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Note --}}
        <div>
            <label for="note_sur_20" class="block text-gray-700 font-semibold mb-2">Note (sur 20) <span class="text-red-500">*</span></label>
            <input type="number" id="note_sur_20" name="note_sur_20" value="{{ old('note_sur_20', 0) }}" required min="0" max="20" step="0.5"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('note_sur_20') border-red-500 @enderror"
                placeholder="12">
            @error('note_sur_20')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4 pt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-save"></i> Créer
            </button>
            <a href="{{ route('admin.notes.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-times"></i> Annuler
            </a>
        </div>
    </form>
</div>
@endsection
