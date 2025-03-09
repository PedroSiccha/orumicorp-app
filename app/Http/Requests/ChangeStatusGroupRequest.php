<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusGroupRequest extends FormRequest
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
            'idGroupClientes' => 'required|array|min:1',
            'idGroupClientes.*' => 'integer|exists:customers,id',
            'statusId' => 'required|integer|exists:customer_statuses,id'
        ];
    }

    public function messages()
    {
        return [
            'idGroupClientes.required' => 'Debe seleccionar al menos un cliente.',
            'idGroupClientes.array' => 'El formato de clientes debe ser un array.',
            'idGroupClientes.min' => 'Debe asignar al menos un cliente.',
            'idGroupClientes.*.integer' => 'Cada cliente debe ser un identificador válido.',
            'idGroupClientes.*.exists' => 'Uno o más clientes no existen en la base de datos.',
            
            'statusId.required' => 'El ID de estado es obligatorio.',
            'statusId.exists' => 'El estado seleccionado no es válido.'
        ];
    }
}
