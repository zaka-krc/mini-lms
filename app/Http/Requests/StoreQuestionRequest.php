<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
            'quiz_id' => 'required|integer|exists:quiz,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'texte.required' => 'Le texte de la question est obligatoire.',
            'quiz_id.required' => 'Vous devez sélectionner un quiz.',
            'quiz_id.exists' => 'Le quiz sélectionné n\'existe pas.',
        ];
    }
}
