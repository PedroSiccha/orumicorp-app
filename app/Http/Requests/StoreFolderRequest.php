<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFolderRequest extends FormRequest
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
            'category_id' => 'required|integer|exists:categories,id'
        ];
    }

    public function messages()
    {
        return [ 
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser un texto válido.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',

            'status.boolean' => 'El estado debe ser un valor booleano válido.',
            
            'category_id.required' => 'El ID de la categoría es obligatorio.',
            'category_id.integer' => 'El ID de la categoría debe ser un número entero.',
            'category_id.exists' => 'La categoría seleccionada no es válida.'
        ];
    }
}
