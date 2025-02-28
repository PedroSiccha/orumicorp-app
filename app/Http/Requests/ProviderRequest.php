<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProviderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'uuid' => 'nullable|string|max:455',
            'user_id' => 'nullable|integer|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser un texto válido.',
            'name.max' => 'El nombre no puede superar los 100 caracteres.',

            'phone.string' => 'El teléfono debe ser un texto válido.',
            'phone.max' => 'El teléfono no puede superar los 100 caracteres.',

            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.max' => 'El correo electrónico no puede superar los 100 caracteres.',

            'uuid.string' => 'El UUID debe ser un texto válido.',
            'uuid.max' => 'El UUID no puede superar los 455 caracteres.',

            'user_id.integer' => 'El ID del usuario debe ser un número entero.',
            'user_id.exists' => 'El usuario seleccionado no existe.',
        ];
    }
}
