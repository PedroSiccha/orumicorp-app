<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditAgentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'lastname' => 'sometimes|string|max:255',
            'code_voiso' => 'sometimes|nullable|string|max:50',
            'status' => 'sometimes|required|boolean',
            'number_turns' => 'sometimes|nullable|integer|min:0',
            'img' => 'sometimes|nullable|string|max:255',
            'area_id' => 'sometimes|required|integer|exists:areas,id'
        ];
    }

    public function messages()
    {
        return [ 
            'name.string' => 'El nombre debe ser un texto válido.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',

            'lastname.string' => 'El apellido debe ser un texto válido.',
            'lastname.max' => 'El apellido no puede superar los 255 caracteres.',

            'code_voiso.string' => 'El código Voiso debe ser un texto válido.',
            'code_voiso.max' => 'El código Voiso no puede superar los 50 caracteres.',

            'status.required' => 'El estado es obligatorio.',
            'status.boolean' => 'El estado solo puede ser verdadero o falso.',

            'number_turns.integer' => 'El número de turnos debe ser un número entero.',
            'number_turns.min' => 'El número de turnos no puede ser negativo.',

            'img.string' => 'La imagen debe ser un texto válido.',
            'img.max' => 'El campo de imagen no puede superar los 255 caracteres.',
            
            'area_id.required' => 'El área es obligatoria.',
            'area_id.integer' => 'El área debe ser un identificador válido.',
            'area_id.exists' => 'El área seleccionada no es válida.'
        ];
    }
}
