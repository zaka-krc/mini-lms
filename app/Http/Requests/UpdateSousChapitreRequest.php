<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSousChapitreRequest extends FormRequest
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
            'contenu' => 'sometimes|string',
            'chapitre_id' => 'sometimes|integer|exists:chapitres,id',
            'ordre' => 'nullable|integer|min:1',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'titre.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'chapitre_id.exists' => 'Le chapitre sélectionné n\'existe pas.',
            'ordre.integer' => 'L\'ordre doit être un nombre entier.',
            'ordre.min' => 'L\'ordre doit être au moins 1.',
        ];
    }
}
