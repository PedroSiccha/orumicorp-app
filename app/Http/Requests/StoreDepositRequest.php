<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepositRequest extends FormRequest
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
            'agent_id' => 'nullable|integer|exists:agents,id',
            'customer_id' => 'nullable|integer|exists:customers,id',
            'date' => 'nullable|date',
            'number' => 'nullable|integer',
            'tipo' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0|max:9999999.99',
            'currency_id' => 'required|integer|exists:currencies,id',
            'transaction_type_id' => 'nullable|integer|exists:transaction_types,id',
            'users_id' => 'nullable|integer|exists:users,id'
        ];
    }

    public function messages()
    {
        return [ 
            'agent_id.integer' => 'El ID del agente debe ser un número entero.',
            'agent_id.exists' => 'El agente seleccionado no es válido.',

            'customer_id.integer' => 'El ID del cliente debe ser un número entero.',
            'customer_id.exists' => 'El cliente seleccionado no es válido.',

            'date.date' => 'La fecha debe ser una fecha válida.',

            'number.integer' => 'El número debe ser un número entero.',

            'tipo.string' => 'El tipo debe ser un texto válido.',
            'tipo.max' => 'El tipo no puede superar los 100 caracteres.',

            'descripcion.string' => 'La descripción debe ser un texto válido.',

            'amount.numeric' => 'El monto debe ser un número válido.',
            'amount.min' => 'El monto no puede ser negativo.',
            'amount.max' => 'El monto no puede superar los 9,999,999.99.',

            'currency_id.required' => 'El ID de la moneda es obligatorio.',
            'currency_id.integer' => 'El ID de la moneda debe ser un número entero.',
            'currency_id.exists' => 'La moneda seleccionada no es válida.',

            'transaction_type_id.integer' => 'El ID del tipo de transacción debe ser un número entero.',
            'transaction_type_id.exists' => 'El tipo de transacción seleccionado no es válido.',
            
            'users_id.integer' => 'El ID del usuario debe ser un número entero.',
            'users_id.exists' => 'El usuario seleccionado no es válido.'
        ];
    }
}
