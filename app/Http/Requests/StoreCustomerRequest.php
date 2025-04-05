<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'code' => 'required|string|max:255|unique:customers,code',
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'nullable|string|regex:/^\+?[0-9]{10,15}$/|max:255',
            'date_admission' => 'required|date|before_or_equal:today',
            'status' => 'required|boolean',
            'img' => 'nullable|string|max:255',
            'user_id' => 'required|integer|exists:users,id',
            'agent_id' => 'nullable|integer|exists:agents,id',
            'optional_phone' => 'nullable|string|regex:/^\+?[0-9]{10,15}$/|max:255',
            'city' => 'nullable|string|max:200',
            'country' => 'nullable|string|max:200',
            'brand_id' => 'nullable|integer|exists:brands,id',
            'api_user_id' => 'nullable|integer|exists:api_users,id',
            'is_lead' => 'nullable|boolean',
            'created_at' => 'nullable|date',
            'updated_at' => 'nullable|date',
            'last_login' => 'nullable|date',
            'last_deposit_date' => 'nullable|date',
            'comment' => 'nullable|string',
            'email' => 'nullable|email|max:100|unique:users,email',
            'password' => 'nullable|string|max:255',
            'id_provider' => 'nullable|integer|exists:providers,id',
            'id_status' => 'nullable|integer|exists:statuses,id',
            'platform_id' => 'nullable|integer|exists:platforms,id',
            'traiding_id' => 'nullable|integer|exists:tradings,id',
            'folder_id' => 'nullable|integer|exists:folders,id',
            'uuid' => 'nullable|uuid|unique:agents,uuid',
            'call_black' => 'nullable|boolean',
            'call_init' => 'nullable|boolean',
            'callbell_uuid' => 'nullable|string|max:455',
            'closed_at' => 'nullable|date',
            'callbell_source' => 'nullable|string|max:450',
            'callbell_href' => 'nullable|string|max:450',
            'callbell_conversationHref' => 'nullable|string|max:450',
            'callbell_tags' => 'nullable|string|max:450',
            'callbell_custom_fields' => 'nullable|string|max:450',
            'callbell_team' => 'nullable|string|max:450',
            'callbell_channel' => 'nullable|string|max:450',
            'callbell_blocked_at' => 'nullable|date',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'El código es obligatorio.',
            'code.string' => 'El código debe ser un texto válido.',
            'code.max' => 'El código no puede superar los 255 caracteres.',
            'code.unique' => 'El código ya está en uso, debe ser único.',
        
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser un texto válido.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',
        
            'lastname.required' => 'El apellido es obligatorio.',
            'lastname.string' => 'El apellido debe ser un texto válido.',
            'lastname.max' => 'El apellido no puede superar los 255 caracteres.',
        
            'phone.string' => 'El teléfono debe ser un texto válido.',
            'phone.regex' => 'El teléfono debe contener solo números y puede incluir un prefijo "+".',
            'phone.max' => 'El teléfono no puede superar los 255 caracteres.',
        
            'date_admission.required' => 'La fecha de admisión es obligatoria.',
            'date_admission.date' => 'Debe ser una fecha válida.',
            'date_admission.before_or_equal' => 'La fecha de admisión no puede ser futura.',
        
            'status.required' => 'El estado es obligatorio.',
            'status.boolean' => 'El estado solo puede ser verdadero o falso.',
        
            'img.string' => 'La imagen debe ser un texto válido.',
            'img.max' => 'El enlace de la imagen no puede superar los 255 caracteres.',
        
            'user_id.required' => 'El usuario es obligatorio.',
            'user_id.integer' => 'El usuario debe ser un número entero.',
            'user_id.exists' => 'El usuario seleccionado no existe.',
        
            'agent_id.integer' => 'El agente debe ser un número entero.',
            'agent_id.exists' => 'El agente seleccionado no existe.',
        
            'optional_phone.string' => 'El teléfono opcional debe ser un texto válido.',
            'optional_phone.max' => 'El teléfono opcional no puede superar los 45 caracteres.',
        
            'city.string' => 'La ciudad debe ser un texto válido.',
            'city.max' => 'La ciudad no puede superar los 200 caracteres.',
        
            'country.string' => 'El país debe ser un texto válido.',
            'country.max' => 'El país no puede superar los 200 caracteres.',
        
            'brand_id.integer' => 'La marca debe ser un número entero.',
            'brand_id.exists' => 'La marca seleccionada no existe.',
        
            'api_user_id.integer' => 'El usuario API debe ser un número entero.',
            'api_user_id.exists' => 'El usuario API seleccionado no existe.',
        
            'is_lead.boolean' => 'El campo "es lead" solo puede ser verdadero o falso.',
        
            'created_at.date' => 'La fecha de creación debe ser válida.',
            'updated_at.date' => 'La fecha de actualización debe ser válida.',
            'last_login.date' => 'La última fecha de inicio de sesión debe ser válida.',
            'last_deposit_date.date' => 'La última fecha de depósito debe ser válida.',
        
            'comment.string' => 'El comentario debe ser un texto válido.',
        
            'email.email' => 'Debe ser una dirección de correo electrónico válida.',
            'email.max' => 'El correo electrónico no puede superar los 100 caracteres.',
            'email.unique' => 'El correo electrónico ya está en uso.',
        
            'password.string' => 'La contraseña debe ser un texto válido.',
            'password.max' => 'La contraseña no puede superar los 255 caracteres.',
        
            'id_provider.integer' => 'El proveedor debe ser un número entero.',
            'id_provider.exists' => 'El proveedor seleccionado no existe.',
        
            'id_status.integer' => 'El estado debe ser un número entero.',
            'id_status.exists' => 'El estado seleccionado no existe.',
        
            'platform_id.integer' => 'La plataforma debe ser un número entero.',
            'platform_id.exists' => 'La plataforma seleccionada no existe.',
        
            'traiding_id.integer' => 'El trading debe ser un número entero.',
            'traiding_id.exists' => 'El trading seleccionado no existe.',
        
            'folder_id.integer' => 'La carpeta debe ser un número entero.',
            'folder_id.exists' => 'La carpeta seleccionada no existe.',
        
            'uuid.uuid' => 'El UUID debe ser un identificador único válido.',
            'uuid.unique' => 'El UUID ya está en uso.',
        
            'call_black.boolean' => 'El campo "call_black" solo puede ser verdadero o falso.',
            'call_init.boolean' => 'El campo "call_init" solo puede ser verdadero o falso.',
        
            'callbell_uuid.string' => 'El UUID de Callbell debe ser un texto válido.',
            'callbell_uuid.max' => 'El UUID de Callbell no puede superar los 455 caracteres.',
        
            'closed_at.date' => 'La fecha de cierre debe ser válida.',
        
            'callbell_source.string' => 'El origen de Callbell debe ser un texto válido.',
            'callbell_source.max' => 'El origen de Callbell no puede superar los 450 caracteres.',
        
            'callbell_href.string' => 'El HREF de Callbell debe ser un texto válido.',
            'callbell_href.max' => 'El HREF de Callbell no puede superar los 450 caracteres.',
        
            'callbell_conversationHref.string' => 'El HREF de la conversación de Callbell debe ser un texto válido.',
            'callbell_conversationHref.max' => 'El HREF de la conversación de Callbell no puede superar los 450 caracteres.',
        
            'callbell_tags.string' => 'Las etiquetas de Callbell deben ser un texto válido.',
            'callbell_tags.max' => 'Las etiquetas de Callbell no pueden superar los 450 caracteres.',
        
            'callbell_custom_fields.string' => 'Los campos personalizados de Callbell deben ser un texto válido.',
            'callbell_custom_fields.max' => 'Los campos personalizados de Callbell no pueden superar los 450 caracteres.',
        
            'callbell_team.string' => 'El equipo de Callbell debe ser un texto válido.',
            'callbell_team.max' => 'El equipo de Callbell no puede superar los 450 caracteres.',
        
            'callbell_channel.string' => 'El canal de Callbell debe ser un texto válido.',
            'callbell_channel.max' => 'El canal de Callbell no puede superar los 450 caracteres.',
        
            'callbell_blocked_at.date' => 'La fecha de bloqueo de Callbell debe ser válida.',
        ];        
    }
}
