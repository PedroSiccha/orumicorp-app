<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComunicationRequest extends FormRequest
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
            'agent_id' => 'required|integer|exists:agents,id',
            'customer_id' => 'nullable|integer|exists:customers,id',
            'date' => 'nullable|date',
            'tipo' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
            'comment' => 'nullable|string',
            'status' => 'nullable|string|max:100'
        ];
    }

    public function messages()
    {
        return [ 
            'agent_id.required' => 'El ID del agente es obligatorio.',
            'agent_id.integer' => 'El ID del agente debe ser un número entero.',
            'agent_id.exists' => 'El agente seleccionado no es válido.',

            'customer_id.integer' => 'El ID del cliente debe ser un número entero.',
            'customer_id.exists' => 'El cliente seleccionado no es válido.',

            'date.date' => 'La fecha debe ser una fecha válida.',

            'tipo.string' => 'El tipo debe ser un texto válido.',
            'tipo.max' => 'El tipo no puede superar los 100 caracteres.',

            'descripcion.string' => 'La descripción debe ser un texto válido.',

            'comment.string' => 'El comentario debe ser un texto válido.',
            
            'status.string' => 'El estado debe ser un texto válido.',
            'status.max' => 'El estado no puede superar los 100 caracteres.'
        ];
    }
}
