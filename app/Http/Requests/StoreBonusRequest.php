<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBonusRequest extends FormRequest
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
            'amount' => 'required|numeric|min:0',
            'observation' => 'nullable|string',
            'status' => 'required|boolean',
            'customer_id' => 'nullable|integer|exists:customers,id',
            'percent_id' => 'nullable|integer|exists:percents,id',
            'commission_id' => 'nullable|integer|exists:commissions,id',
            'exchange_rate_id' => 'nullable|integer|exists:exchange_rates,id',
            'agent_id' => 'required|integer|exists:agents,id',
            'action_id' => 'required|integer|in:1'
        ];
    }

    /**
     * Get custom error messages for validation rules. 
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [ 
            'date_admission.required' => 'La fecha de admisión es obligatoria.',
            'date_admission.date' => 'La fecha de admisión debe ser una fecha válida.',

            'amount.required' => 'El monto es obligatorio.',
            'amount.numeric' => 'El monto debe ser un número válido.',
            'amount.min' => 'El monto no puede ser negativo.',

            'observation.string' => 'La observación debe ser un texto válido.',

            'status.required' => 'El estado es obligatorio.',
            'status.boolean' => 'El estado solo puede ser verdadero o falso.',

            'customer_id.integer' => 'El cliente debe ser un identificador válido.',
            'customer_id.exists' => 'El cliente seleccionado no es válido.',

            'percent_id.integer' => 'El porcentaje debe ser un identificador válido.',
            'percent_id.exists' => 'El porcentaje seleccionado no es válido.',

            'commission_id.integer' => 'La comisión debe ser un identificador válido.',
            'commission_id.exists' => 'La comisión seleccionada no es válida.',

            'exchange_rate_id.integer' => 'El tipo de cambio debe ser un identificador válido.',
            'exchange_rate_id.exists' => 'El tipo de cambio seleccionado no es válido.',

            'agent_id.required' => 'El agente es obligatorio.',
            'agent_id.integer' => 'El agente debe ser un identificador válido.',
            'agent_id.exists' => 'El agente seleccionado no es válido.',
            
            'action_id.required' => 'El ID de acción es obligatorio.',
            'action_id.integer' => 'El ID de acción debe ser un número entero.',
            'action_id.in' => 'El ID de acción debe ser 1.'
        ];
    }
}
