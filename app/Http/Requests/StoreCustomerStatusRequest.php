<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerStatusRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'color' => 'required|string|max:50',
            'description' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [ 
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser un texto válido.',
            'name.max' => 'El nombre no puede superar los 50 caracteres.',

            'color.required' => 'El color es obligatorio.',
            'color.string' => 'El color debe ser un texto válido.',
            'color.max' => 'El color no puede superar los 50 caracteres.',
            
            'description.string' => 'La descripción debe ser un texto válido.'
        ];
    }
}
