<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReponseRequest extends FormRequest
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
            'texte' => 'required|string',
            'est_correcte' => 'required|boolean',
            'question_id' => 'required|integer|exists:questions,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'texte.required' => 'Le texte de la réponse est obligatoire.',
            'est_correcte.required' => 'Veuillez indiquer si la réponse est correcte.',
            'est_correcte.boolean' => 'La valeur de est_correcte doit être un booléen.',
            'question_id.required' => 'Vous devez sélectionner une question.',
            'question_id.exists' => 'La question sélectionnée n\'existe pas.',
        ];
    }
}
