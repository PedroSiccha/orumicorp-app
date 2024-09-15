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
use Spatie\Permission\Models\Role;

class AgentService implements AgentInterface {
    public function __construct() {}

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
        $resp = 0;

        $pass = $requestData->code . $requestData->codeVoiso;

        $role = Role::find($requestData->rol_id);

        $user = new User();
        $user->name = $requestData->name;
        $user->email = $requestData->email;
        $user->password = Hash::make($pass);

        if ($user->save()) {
            $user->assignRole($role);
            $agent = new Agent();
            $agent->code = $requestData->code;
            $agent->name = $requestData->name;
            $agent->lastname = $requestData->lastname;
            $agent->code_voiso = $requestData->codeVoiso;
            $agent->status = true;
            $agent->area_id = $requestData->area_id;
            $agent->user_id = $user->id;
            $agent->status_voiso = 'LIBRE';
            if ($agent->save()) {
                $resp = 1;
            }
        }

        return $resp;
    }

    public function updateAgent($requestData) {
        $resp = 0;

        $agent = Agent::find($requestData->id);
        $agent->code = $requestData->code;
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
        $user = Auth::user();
        $agent = Agent::where('user_id', $user->id)->first();
        $client = Customers::where('user_id', $user->id)->first();

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
}
