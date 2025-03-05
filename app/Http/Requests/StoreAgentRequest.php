<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreAgentRequest extends FormRequest
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
            'code' => 'required|string|max:50|unique:agents,code',
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'required',
            'status' => 'required|boolean',
            'number_turns' => 'nullable|integer|min:0',
            'img' => 'nullable|string|max:255',
            'status_voiso' => 'nullable|boolean',
            'area_id' => 'required|integer|exists:areas,id',
            'user_id' => 'required|integer|exists:users,id',
            'uuid' => 'nullable|uuid|unique:agents,uuid'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        if (!$this->has('uuid')) {
            $this->merge(['uuid' => (string) Str::uuid()]);
        }
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'code.required' => 'El código del agente es obligatorio.',
            'code.string' => 'El código del agente debe ser un texto válido.',
            'code.max' => 'El código del agente no puede superar los 50 caracteres.',
            'code.unique' => 'El código del agente ya está en uso.',

            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser un texto válido.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',

            'lastname.required' => 'El apellido es obligatorio.',
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

            'status_voiso.boolean' => 'El estado de Voiso solo puede ser verdadero o falso.',

            'area_id.required' => 'El área es obligatoria.',
            'area_id.integer' => 'El área debe ser un identificador válido.',
            'area_id.exists' => 'El área seleccionada no es válida.',
            'user_id.required' => 'El usuario es obligatorio.',
            'user_id.integer' => 'El usuario debe ser un identificador válido.',
            'user_id.exists' => 'El usuario seleccionado no es válido.',
            'uuid.uuid' => 'El UUID debe ser un identificador único válido.',
            'uuid.unique' => 'El UUID ya está en uso.'
        ];
    }
}
