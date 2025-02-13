<?php

namespace App\Services;

use App\Interfaces\AgentInterface;
use App\Models\Agent;
use App\Models\Area;
use App\Models\Customers;
use App\Models\Premio;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AgentService implements AgentInterface {
    protected $utils;
    public function __construct(
        Utils $utils,
    ) {
        $this->utils = $utils;
    }

    public function index()
    {
        $user_id = Auth::user()->id;

        $agent = Agent::where('user_id', $user_id)->first();
        $client = Customers::where('user_id', $user_id)->first();
        $rouletteSpin = $agent->number_turns ?: 0;

        $dataUser = null;

        if ($agent) {
            $dataUser = $agent;
        }

        if ($client) {
            $dataUser = $client;
        }

        $agents = Agent::orderBy('lastname')->paginate(10);
        $areas = Area::where('status', true)->get();
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $roles = Role::get();

        return compact('agents', 'areas', 'premios1', 'premios2', 'roles', 'dataUser', 'rouletteSpin');
    }

    public function searchAgent($request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $name = "";

        try {
            $agent = Agent::where('code_voiso', $request->codeVoiso)->orWhere('code', $request->codeVoiso)->first();

            if (is_null($agent)) {
                $mensaje = "El agente no existe";
            } else {
                $title = "Éxito";
                $status = "success";
                $name =  $agent->name . " " . $agent->lastname;
                $mensaje = "Agente encontrado exitosamente";
            }

        } catch (Exception $e) {
            $mensaje = "Error " . $e->getMessage();
        }

        return [
            'name' => $name,
            'title' => $title,
            'mensaje' => $mensaje,
            'status' => $status
        ];

        // return response()->json(["name" => $name, "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function saveAgent($requestData) {

        $role = Role::find($requestData->rol_id);
        if (!$role) {
            return [
                'title' => 'Error',
                'mensaje' => 'El rol proporcionado no existe.',
                'status' => 'error'
            ];
        }

        $validator = Validator::make($requestData->all(), [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            // 'code' => 'required|string|unique:agents,code|max:50',
            'codeVoiso' => 'required|string|unique:agents,code_voiso|max:50',
            'area_id' => 'required|integer|exists:areas,id',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'lastname.required' => 'El apellido es obligatorio.',
            'lastname.string' => 'El apellido debe ser una cadena de texto.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            // 'code.required' => 'El código es obligatorio.',
            // 'code.string' => 'El código debe ser una cadena de texto.',
            // 'code.unique' => 'El código ya está registrado.',
            'codeVoiso.required' => 'El código Voiso es obligatorio.',
            'codeVoiso.string' => 'El código Voiso debe ser una cadena de texto.',
            'codeVoiso.unique' => 'El código Voiso ya está registrado.',
            'area_id.required' => 'El área es obligatoria.',
            'area_id.integer' => 'El área proporcionada no existe.',
            'area_id.exists' => 'El área proporcionada no existe.',
        ]);

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
            return [
                'title' => 'Error',
                'mensaje' => $errorMessages,
                'status' => 'error'
            ];
        }

        $pass = /*$requestData->code . */$requestData->codeVoiso;

        $user = new User();
        $user->name = $requestData->name;
        $user->email = $requestData->email;
        $user->password = Hash::make($pass);

        if ($user->save()) {
            $user->assignRole($role);
            $agent = new Agent();
            // $agent->code = $requestData->code;
            $agent->name = $requestData->name;
            $agent->lastname = $requestData->lastname;
            $agent->code_voiso = $requestData->codeVoiso;
            $agent->status = true;
            $agent->area_id = $requestData->area_id;
            $agent->user_id = $user->id;
            $agent->status_voiso = 'LIBRE';
            if ($agent->save()) {
                return [
                    'title' => 'Correcto',
                    'mensaje' => 'Se guardó el agente correctamente.',
                    'status' => 'success'
                ];
            } else {
                $user->delete();
                return [
                    'title' => 'Error',
                    'mensaje' => 'Error al guardar el agente.',
                    'status' => 'error'
                ];
            }
        } else {
            return [
                'title' => 'Error',
                'mensaje' => 'Error al guardar el usuario.',
                'status' => 'error'
            ];
        }

        return [
            'title' => 'Correcto',
            'mensaje' => 'Se guardó el agente correctamente.',
            'status' => 'success'
        ];
    }

    public function updateAgent($requestData) {
        $resp = 0;

        $agent = Agent::find($requestData->id);
        // $agent->code = $requestData->code;
        $agent->name = $requestData->name;
        $agent->lastname = $requestData->lastname;
        $agent->area_id = $requestData->area_id;
        $agent->code_voiso = $requestData->codeVoiso;
        if ($agent->save()) {
            $user = User::find($agent->user_id);
            $user->name = $requestData->name;
            if ($user->save()) {
                if ($requestData->rol_id) {
                    $role = Role::find($requestData->rol_id);
                    $user->assignRole($role);
                }
                $resp = 1;
            }
        }

        return $resp;
    }

    public function cambiarEstadoAgente($agentId, $status) {
        $resp = 0;
        $agent = Agent::find($agentId);
        $agent->status = $status;
        if ($agent->save()) {
            $resp = 1;
        }
        return $resp;
    }

    public function eliminarAgente($agentId) {
        $resp = 0;
        $agent = Agent::find($agentId);
        $user = User::find($agent->user_id);
        if ($agent->delete()) {
            if ($user->delete()) {
                $resp = 1;
            }
        }
        return $resp;
    }

    public function saveNumberTurns($agentId, $cantidad) {
        $resp = 0;
        $agent = Agent::find($agentId);
        $agent->number_turns = $cantidad;
        if ($agent->save()) {
            $resp = 1;
        }
        return $resp;
    }

    public function uploadImg($request) {
        $dataImg = $request->image;
        $subido = "";
        $urlGuardar = "";
        $agent = Agent::where('user_id', $request->user_id)->first();
        $client = Customers::where('user_id', $request->user_id)->first();

        if ($request->hasFile('image')) {
            $nombre = $dataImg->getClientOriginalName();
            $extension = $dataImg->getClientOriginalExtension();
            $nuevoNombre = $nombre . "." . $extension;
            $subido = Storage::disk('perfil')->put($nombre, \File::get($dataImg));
            if ($subido) {
                $urlGuardar = 'img/perfil/' . $nombre;
            }
        }

        if ($agent) {
            $agent->img = $urlGuardar;
            $agent->save();
        }

        if ($client) {
            $client->img = $urlGuardar;
            $client->save();
        }

        // Retornar una respuesta JSON para evitar el error en el frontend
        return [
            'success' => $subido,
            'message' => $subido ? 'Imagen subida correctamente' : 'Error al subir la imagen',
            'path' => $urlGuardar
        ];
    }

    public function changePassword($request) {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        $user = Auth::user();
        $user = User::find($user->id);
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            $title = "Correcto";
            $mensaje = "La contraseña se actualizó correctamente";
            $status = "success";
        }
        return compact('title', 'mensaje', 'status');
    }

    public function filterAgent($request)
    {
        $search = $request->code;

        $agents = Agent::where('area_id', $request->area)
                        ->where(function ($query) use ($search) {
                            $query->whereRaw('CONCAT(name, " ", lastname) LIKE ?', ['%'.$search.'%'])
                                ->orWhere('code', 'like', '%'.$search.'%');
                        })->paginate(10);

        return $agents;
    }

    public function getAgent()
    {
        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();
        return $agent;
    }
}
