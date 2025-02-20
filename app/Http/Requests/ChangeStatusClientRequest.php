<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusClientRequest extends FormRequest
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
            'id' => 'required|integer|exists:customers,id',
            'status' => 'required|boolean'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'El ID del cliente es obligatorio.',
            'id.integer' => 'El ID del cliente debe ser un número entero.',
            'id.exists' => 'El cliente no existe en la base de datos.',
            'status.required' => 'El estado del cliente es obligatorio.',
            'status.boolean' => 'El estado del cliente debe ser un valor booleano.'
        ];
    }
}
