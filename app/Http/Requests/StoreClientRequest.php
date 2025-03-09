<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|unique:customers,phone',
            'name' => 'required|string',
            'lastname' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'El correo ya está registrado.',

            'phone.required' => 'El número de teléfono es obligatorio.',
            'phone.unique' => 'El número de teléfono ya está registrado.',

            'name.required' => 'El nombre es obligatorio.',
            
            'lastname.required' => 'El apellido es obligatorio.',
        ];
    }
}
