<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrizeRequest extends FormRequest
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
            'value' => 'required|numeric|min:0|max:999999.99',
            'order' => 'required|integer|min:1',
            'type' => 'required|integer',
            'status' => 'nullable|boolean',
            'active' => 'nullable|boolean',
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

            'value.required' => 'El valor es obligatorio.',
            'value.numeric' => 'El valor debe ser un número.',
            'value.min' => 'El valor no puede ser negativo.',
            'value.max' => 'El valor no puede superar 999999.99.',

            'order.required' => 'El orden es obligatorio.',
            'order.integer' => 'El orden debe ser un número entero.',
            'order.min' => 'El orden debe ser al menos 1.',

            'type.required' => 'El tipo es obligatorio.',
            'type.integer' => 'El tipo debe ser un número entero.',

            'status.boolean' => 'El estado solo puede ser verdadero o falso.',

            'active.boolean' => 'El campo activo solo puede ser verdadero o falso.',
        ];
    }
}
