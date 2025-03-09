<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'document' => 'nullable|string|max:255',
            'timeStart' => 'nullable|date_format:H:i:s',
            'timeEnd' => 'nullable|date_format:H:i:s|after:timeStart',
            'date' => 'nullable|date',
            'agent_id' => 'nullable|integer|exists:agents,id',
            'priority_id' => 'nullable|integer|exists:priorities,id',
            'customer_id' => 'nullable|integer|exists:customers,id',
            'start' => 'nullable|date_format:Y-m-d H:i:s',
            'end' => 'nullable|date_format:Y-m-d H:i:s|after_or_equal:start',
            'title' => 'nullable|string|max:45'
        ];
    }

    public function messages()
    {
        return [ 
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser un texto válido.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',

            'description.string' => 'La descripción debe ser un texto válido.',
            'description.max' => 'La descripción no puede superar los 255 caracteres.',

            'document.string' => 'El documento debe ser un texto válido.',
            'document.max' => 'El documento no puede superar los 255 caracteres.',

            'timeStart.date_format' => 'La hora de inicio debe estar en formato HH:MM:SS.',

            'timeEnd.date_format' => 'La hora de finalización debe estar en formato HH:MM:SS.',
            'timeEnd.after' => 'La hora de finalización debe ser posterior a la hora de inicio.',

            'date.date' => 'La fecha debe ser válida.',

            'agent_id.integer' => 'El ID del agente debe ser un número entero.',
            'agent_id.exists' => 'El agente seleccionado no es válido.',

            'priority_id.integer' => 'El ID de prioridad debe ser un número entero.',
            'priority_id.exists' => 'La prioridad seleccionada no es válida.',

            'customer_id.integer' => 'El ID del cliente debe ser un número entero.',
            'customer_id.exists' => 'El cliente seleccionado no es válido.',

            'start.date_format' => 'La fecha de inicio debe estar en formato YYYY-MM-DD HH:MM:SS.',

            'end.date_format' => 'La fecha de finalización debe estar en formato YYYY-MM-DD HH:MM:SS.',
            'end.after_or_equal' => 'La fecha de finalización no puede ser anterior a la fecha de inicio.',
            
            'title.string' => 'El título debe ser un texto válido.',
            'title.max' => 'El título no puede superar los 45 caracteres.'
        ];
    }
}
