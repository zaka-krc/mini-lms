<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titre' => 'sometimes|string|max:255',
            'sous_chapitre_id' => 'sometimes|integer|exists:sous_chapitres,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'titre.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'sous_chapitre_id.exists' => 'Le sous-chapitre sélectionné n\'existe pas.',
        ];
    }
}
