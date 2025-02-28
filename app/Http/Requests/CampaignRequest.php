<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampaignRequest extends FormRequest
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
            'brand_id' => 'required|integer|exists:brands,id',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre de la campaña es obligatorio.',
            'name.string' => 'El nombre debe ser un texto válido.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',

            'brand_id.required' => 'La marca es obligatoria.',
            'brand_id.integer' => 'El ID de la marca debe ser un número.',
            'brand_id.exists' => 'La marca seleccionada no existe.',

            'description.string' => 'La descripción debe ser un texto válido.',

            'start_date.date' => 'La fecha de inicio debe ser una fecha válida.',
            'end_date.date' => 'La fecha de finalización debe ser una fecha válida.',
            'end_date.after_or_equal' => 'La fecha de finalización debe ser posterior o igual a la fecha de inicio.'
        ];
    }
}
