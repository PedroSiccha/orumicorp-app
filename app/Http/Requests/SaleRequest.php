<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
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
            'date_admission' => 'required|date',
            'amount' => 'required|numeric|min:0|max:99999999.99',
            'percent' => 'nullable|numeric|min:0|max:100',
            'exchange_rate' => 'nullable|numeric|min:0|max:999999.99',
            'commission' => 'nullable|numeric|min:0|max:99999999.99',
            'observation' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
            'customer_id' => 'nullable|integer|exists:customers,id',
            'agent_id' => 'nullable|integer|exists:agents,id',
            'user_id' => 'nullable|integer|exists:users,id',
            'action_id' => 'nullable|integer|exists:actions,id',
        ];
    }

    public function messages()
    {
        return [
            'date_admission.required' => 'La fecha de admisión es obligatoria.',
            'date_admission.date' => 'La fecha de admisión debe ser válida.',

            'amount.required' => 'El monto es obligatorio.',
            'amount.numeric' => 'El monto debe ser un número válido.',
            'amount.min' => 'El monto no puede ser negativo.',
            'amount.max' => 'El monto no puede superar los 99,999,999.99.',

            'percent.numeric' => 'El porcentaje debe ser un número válido.',
            'percent.min' => 'El porcentaje no puede ser negativo.',
            'percent.max' => 'El porcentaje no puede ser mayor a 100.',

            'exchange_rate.numeric' => 'La tasa de cambio debe ser un número válido.',
            'exchange_rate.min' => 'La tasa de cambio no puede ser negativa.',
            'exchange_rate.max' => 'La tasa de cambio no puede superar 999,999.99.',

            'commission.numeric' => 'La comisión debe ser un número válido.',
            'commission.min' => 'La comisión no puede ser negativa.',
            'commission.max' => 'La comisión no puede superar los 99,999,999.99.',

            'observation.string' => 'La observación debe ser un texto válido.',
            'observation.max' => 'La observación no puede superar los 255 caracteres.',

            'status.boolean' => 'El estado solo puede ser verdadero o falso.',

            'customer_id.integer' => 'El ID del cliente debe ser un número entero.',
            'customer_id.exists' => 'El cliente seleccionado no existe.',

            'agent_id.integer' => 'El ID del agente debe ser un número entero.',
            'agent_id.exists' => 'El agente seleccionado no existe.',

            'user_id.integer' => 'El ID del usuario debe ser un número entero.',
            'user_id.exists' => 'El usuario seleccionado no existe.',

            'action_id.integer' => 'El ID de la acción debe ser un número entero.',
            'action_id.exists' => 'La acción seleccionada no existe.',
        ];
    }
}
