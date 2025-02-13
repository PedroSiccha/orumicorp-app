<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignGroupAgentRequest extends FormRequest
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
            'dni_agent' => 'required|string|exists:agents,code_voiso',
            'idGroupClientes' => 'required|array|min:1',
            'idGroupClientes.*' => 'integer|exists:customers,id'
        ];
    }

    public function messages()
    {
        return [
            'dni_agent.required' => 'El código del agente es obligatorio.',
            'dni_agent.exists' => 'El agente no existe.',
            'idGroupClientes.required' => 'Debe seleccionar al menos un cliente.',
            'idGroupClientes.array' => 'El formato de clientes debe ser un array.',
            'idGroupClientes.min' => 'Debe asignar al menos un cliente.',
            'idGroupClientes.*.integer' => 'Cada cliente debe ser un identificador válido.',
            'idGroupClientes.*.exists' => 'Uno o más clientes no existen en la base de datos.'
        ];
    }
}
