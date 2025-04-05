<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTargetRequest extends FormRequest
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
            'amount' => 'required|numeric|min:0|max:999999.99',
            'month' => 'required|integer|min:1|max:12',
            'observation' => 'nullable|string|max:255',
            'status' => 'required|boolean',
            'agent_id' => 'required|integer|exists:agents,id'
        ];
    }

    public function messages()
    {
        return [ 
            'amount.required' => 'El monto es obligatorio.',
            'amount.numeric' => 'El monto debe ser un número válido.',
            'amount.min' => 'El monto no puede ser negativo.',
            'amount.max' => 'El monto no puede superar los 999,999.99.',

            'month.required' => 'El mes es obligatorio.',
            'month.integer' => 'El mes debe ser un número entero.',
            'month.min' => 'El mes debe estar entre 1 y 12.',
            'month.max' => 'El mes debe estar entre 1 y 12.',

            'observation.string' => 'La observación debe ser un texto válido.',
            'observation.max' => 'La observación no puede superar los 255 caracteres.',

            'status.required' => 'El estado es obligatorio.',
            'status.boolean' => 'El estado debe ser un valor booleano válido.',
            
            'agent_id.required' => 'El ID del agente es obligatorio.',
            'agent_id.integer' => 'El ID del agente debe ser un número entero.',
            'agent_id.exists' => 'El agente seleccionado no es válido.'
        ];
    }
}
