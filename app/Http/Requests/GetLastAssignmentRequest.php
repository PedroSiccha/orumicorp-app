<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetLastAssignmentRequest extends FormRequest
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
            'customer_id' => 'required|integer|exists:customers,id'
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'El ID del cliente es obligatorio.',
            'customer_id.integer' => 'El ID del cliente debe ser un número entero.',
            'customer_id.exists' => 'El cliente no existe en la base de datos.'
        ];
    }
}
