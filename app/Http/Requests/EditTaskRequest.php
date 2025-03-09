<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditTaskRequest extends FormRequest
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
            'description' => 'nullable|string',
            'status' => 'required|boolean'
        ];
    }

    public function messages()
    {
        return [ 
            'name.required' => 'El nombre del área es obligatorio.',
            'name.string' => 'El nombre debe ser un texto válido.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',

            'description.string' => 'La descripción debe ser un texto válido.',
            
            'status.required' => 'El estado es obligatorio.',
            'status.boolean' => 'El estado solo puede ser verdadero o falso.'
        ];
    }
}
