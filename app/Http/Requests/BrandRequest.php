<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'site_url' => 'required|string|url|max:255',
            'status' => 'required|in:active,inactive'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del sitio es obligatorio.',
            'name.string' => 'El nombre debe ser un texto válido.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',
            
            'site_url.required' => 'La URL del sitio es obligatoria.',
            'site_url.string' => 'La URL debe ser una cadena de texto.',
            'site_url.url' => 'Debe ingresar una URL válida.',
            'site_url.max' => 'La URL no puede superar los 255 caracteres.',

            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado solo puede ser "active" o "inactive".'
        ];
    }
}
