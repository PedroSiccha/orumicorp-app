<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveAgentRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Puedes modificar esto si necesitas lógica de autorización.
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'codeVoiso' => 'required|string|unique:agents,code_voiso|max:50',
            'area_id' => 'required|integer|exists:areas,id',
            'rol_id' => 'required|integer|exists:roles,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'lastname.required' => 'El apellido es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'codeVoiso.required' => 'El código Voiso es obligatorio.',
            'codeVoiso.unique' => 'El código Voiso ya está registrado.',
            'area_id.required' => 'El área es obligatoria.',
            'area_id.exists' => 'El área proporcionada no existe.',
            'rol_id.required' => 'El rol es obligatorio.',
            'rol_id.exists' => 'El rol proporcionado no existe.',
        ];
    }
}