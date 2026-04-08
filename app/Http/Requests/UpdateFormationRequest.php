<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormationRequest extends FormRequest
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
            'nom' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'niveau' => 'sometimes|string|in:débutant,intermédiaire,avancé',
            'duree' => 'sometimes|integer|min:1',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'niveau.in' => 'Le niveau doit être débutant, intermédiaire ou avancé.',
            'duree.integer' => 'La durée doit être un nombre entier.',
            'duree.min' => 'La durée doit être au moins 1.',
        ];
    }
}
