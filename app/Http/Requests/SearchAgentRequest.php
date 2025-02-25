<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchAgentRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Puedes modificar esto si necesitas lógica de autorización.
    }

    public function rules()
    {
        return [
            'code' => 'required|string|max:50',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'El código del agente es obligatorio.',
            'code.string' => 'El código debe ser un texto válido.',
            'code.max' => 'El código no puede exceder los 50 caracteres.',
        ];
    }
}