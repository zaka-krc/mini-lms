<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReponseRequest extends FormRequest
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
            'texte' => 'sometimes|string',
            'est_correcte' => 'sometimes|boolean',
            'question_id' => 'sometimes|integer|exists:questions,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'est_correcte.boolean' => 'La valeur de est_correcte doit être un booléen.',
            'question_id.exists' => 'La question sélectionnée n\'existe pas.',
        ];
    }
}
