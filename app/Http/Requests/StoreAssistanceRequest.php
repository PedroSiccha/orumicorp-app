<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssistanceRequest extends FormRequest
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
            'hour' => 'required|date_format:H:i:s',
            'date' => 'required|date',
            'date_end' => 'nullable|date|after_or_equal:date',
            'type' => 'required|string|max:255',
            'observation' => 'nullable|string|max:255',
            'agent_id' => 'required|integer|exists:agents,id'
        ];
    }

    public function messages()
    {
        return [ 
            'hour.required' => 'La hora es obligatoria.',
            'hour.date_format' => 'La hora debe estar en formato HH:MM:SS.',

            'date.required' => 'La fecha es obligatoria.',
            'date.date' => 'La fecha debe ser válida.',
            'date_end.date' => 'La fecha de finalización debe ser válida.',
            'date_end.after_or_equal' => 'La fecha de finalización no puede ser anterior a la fecha de inicio.',

            'type.required' => 'El tipo es obligatorio.',
            'type.string' => 'El tipo debe ser un texto válido.',
            'type.max' => 'El tipo no puede superar los 255 caracteres.',

            'observation.string' => 'La observación debe ser un texto válido.',
            'observation.max' => 'La observación no puede superar los 255 caracteres.',
            
            'agent_id.required' => 'El ID del agente es obligatorio.',
            'agent_id.integer' => 'El ID del agente debe ser un número entero.',
            'agent_id.exists' => 'El agente seleccionado no es válido.'
        ];
    }
}
