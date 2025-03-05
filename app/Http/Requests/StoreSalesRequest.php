<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalesRequest extends FormRequest
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
            'date_admission' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'observation' => 'nullable|string',
            'status' => 'required|boolean',
            'percent' => 'nullable|numeric',
            'commission' => 'nullable|numeric',
            'exchange_rate' => 'nullable|numeric',
            'agent_id' => 'nullable|integer|exists:agents,id',
            'action_id' => 'nullable|integer|exists:actions,id',
            'user_id' => 'nullable|integer|exists:users,id',
        ];
    }

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

            'agent_id.integer' => 'El agente debe ser un identificador válido.',
            'agent_id.exists' => 'El agente seleccionado no es válido.',

            'action_id.integer' => 'La acción debe ser un identificador válido.',
            'action_id.exists' => 'La acción seleccionada no es válida.',

            'user_id.integer' => 'El usuario debe ser un identificador válido.',
            'user_id.exists' => 'El usuario seleccionado no es válido.',
        ];
    }
}
