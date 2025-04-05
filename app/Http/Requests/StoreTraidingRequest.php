<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTraidingRequest extends FormRequest
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
            'code' => 'required|string|max:100|unique:codes,code',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ];
    }

    public function messages()
    {
        return [ 
            'code.required' => 'El código es obligatorio.',
            'code.string' => 'El código debe ser un texto válido.',
            'code.max' => 'El código no puede superar los 100 caracteres.',
            'code.unique' => 'El código ya está en uso.',

            'description.string' => 'La descripción debe ser un texto válido.',
            
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado debe ser "active" o "inactive".'
        ];
    }
}
