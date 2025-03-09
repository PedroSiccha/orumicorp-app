<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShooterRequest extends FormRequest
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
            'status' => 'nullable|boolean',
            'start' => 'nullable|date_format:Y-m-d H:i:s',
            'end' => 'nullable|date_format:Y-m-d H:i:s|after_or_equal:start',
            'folder_id' => 'nullable|integer|exists:folders,id'
        ];
    }

    public function messages()
    {
        return [ 
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser un texto válido.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',

            'status.boolean' => 'El estado debe ser un valor booleano válido.',

            'start.date_format' => 'La fecha de inicio debe estar en formato YYYY-MM-DD HH:MM:SS.',

            'end.date_format' => 'La fecha de finalización debe estar en formato YYYY-MM-DD HH:MM:SS.',
            'end.after_or_equal' => 'La fecha de finalización no puede ser anterior a la fecha de inicio.',
            
            'folder_id.integer' => 'El ID de la carpeta debe ser un número entero.',
            'folder_id.exists' => 'La carpeta seleccionada no es válida.'
        ];
    }
}
