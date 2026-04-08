<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'user_id'     => 'required|integer|exists:users,id',
            'quiz_id'     => 'required|integer|exists:quiz,id',
            'note_sur_20' => 'required|numeric|min:0|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required'     => 'Vous devez sélectionner un apprenant.',
            'user_id.exists'       => 'L\'apprenant sélectionné n\'existe pas.',
            'quiz_id.required'     => 'Vous devez sélectionner un quiz.',
            'quiz_id.exists'       => 'Le quiz sélectionné n\'existe pas.',
            'note_sur_20.required' => 'La note est obligatoire.',
            'note_sur_20.numeric'  => 'La note doit être un nombre.',
            'note_sur_20.min'      => 'La note doit être au minimum 0.',
            'note_sur_20.max'      => 'La note doit être au maximum 20.',
        ];
    }
}
