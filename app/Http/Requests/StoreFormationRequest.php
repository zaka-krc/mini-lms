<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormationRequest extends FormRequest
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
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'niveau' => 'required|string|in:débutant,intermédiaire,avancé',
            'duree' => 'required|integer|min:1',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom de la formation est obligatoire.',
            'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'description.required' => 'La description est obligatoire.',
            'niveau.required' => 'Le niveau est obligatoire.',
            'niveau.in' => 'Le niveau doit être débutant, intermédiaire ou avancé.',
            'duree.required' => 'La durée est obligatoire.',
            'duree.integer' => 'La durée doit être un nombre entier.',
            'duree.min' => 'La durée doit être au moins 1.',
        ];
    }
}
