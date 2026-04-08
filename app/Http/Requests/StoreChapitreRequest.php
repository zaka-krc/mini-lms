<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChapitreRequest extends FormRequest
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
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'formation_id' => 'required|integer|exists:formations,id',
            'ordre' => 'nullable|integer|min:1',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre du chapitre est obligatoire.',
            'titre.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'description.required' => 'La description est obligatoire.',
            'formation_id.required' => 'Vous devez sélectionner une formation.',
            'formation_id.exists' => 'La formation sélectionnée n\'existe pas.',
            'ordre.integer' => 'L\'ordre doit être un nombre entier.',
            'ordre.min' => 'L\'ordre doit être au moins 1.',
        ];
    }
}
