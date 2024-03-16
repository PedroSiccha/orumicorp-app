<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Http\Requests\StoreAgentRequest;
use App\Http\Requests\UpdateAgentRequest;
use App\Models\Area;
use App\Models\Customers;
use App\Models\Premio;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        $agents = Agent::orderBy('lastname')->get();
        $areas = Area::where('status', true)->get();
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $roles = Role::get();
        return view('agent.index', compact('agents', 'areas', 'premios1', 'premios2', 'roles', 'dataUser', 'rouletteSpin'));
    }

    public function searchAgent(Request $request)
    {
        $agent = Agent::where('dni', $request->dni)
                  ->orWhere('code', $request->dni)
                  ->first();

        $name = $agent->name . " " . $agent->lastname;
        return response()->json(["name"=>$name]);
    }

    public function saveAgent(Request $request)
    {
        $resp = 0;

        $role = Role::find($request->rol_id);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->dni);

        if ($user->save()) {
            $user->assignRole($role);
            $agent = new Agent();
            $agent->code = $request->code;
            $agent->name = $request->name;
            $agent->lastname = $request->lastname;
            $agent->dni = $request->dni;
            $agent->status = true;
            $agent->area_id = $request->area_id;
            $agent->user_id = $user->id;
            if ($agent->save()) {
                $resp = 1;
            }
        }

        $agents = Agent::orderBy('lastname')->get();

        return response()->json(["view"=>view('agent.list.listAgent', compact('agents'))->render(), "resp"=>$resp]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateAgent(Request $request)
    {
        $resp = 0;

        $agent = Agent::find($request->id);
        $agent->code = $request->code;
        $agent->name = $request->name;
        $agent->lastname = $request->lastname;
        $agent->area_id = $request->area_id;
        if ($agent->save()) {
            $user = User::find($agent->user_id);
            $user->name = $request->name;
            if ($user->save()) {
                if ($request->rol_id) {
                    $role = Role::find($request->rol_id);
                    $user->assignRole($role);
                }
                $resp = 1;
            }
        }

        $agents = Agent::orderBy('lastname')->get();

        return response()->json(["view"=>view('agent.list.listAgent', compact('agents'))->render(), "resp"=>$resp]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAgentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function cambiarEstadoAgente(Request $request)
    {
        $resp = 0;
        $agent = Agent::find($request->id);
        $agent->status = $request->status;
        if ($agent->save()) {
            $resp = 1;
        }
        $agents = Agent::orderBy('lastname')->get();

        return response()->json(["view"=>view('agent.list.listAgent', compact('agents'))->render(), "resp"=>$resp]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function eliminarAgente(Request $request)
    {
        $resp = 0;
        $agent = Agent::find($request->id);
        $user = User::find($agent->user_id);
        if ($agent->delete()) {
            if ($user->delete()) {
                $resp = 1;
            }
        }

        $agents = Agent::orderBy('lastname')->get();

        return response()->json(["view"=>view('agent.list.listAgent', compact('agents'))->render(), "resp"=>$resp]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function saveNumberTurns(Request $request)
    {
        $resp = 0;
        $agent = Agent::find($request->id);
        $agent->number_turns = $request->cant;
        if ($agent->save()) {
            $resp = 1;
        }
        $agents = Agent::orderBy('lastname')->get();

        return response()->json(["view"=>view('agent.list.listAgent', compact('agents'))->render(), "resp"=>$resp]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAgentRequest  $request
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function filterAgent(Request $request)
    {
        $search = $request->code;

        $agents = Agent::where('area_id', $request->area)
                        ->where(function ($query) use ($search) {
                            $query->whereRaw('CONCAT(name, " ", lastname) LIKE ?', ['%'.$search.'%'])
                                ->orWhere('code', 'like', '%'.$search.'%');
                        })->get();

        return response()->json(["view"=>view('agent.list.listAgent', compact('agents'))->render()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function uploadImg(Request $request)
    {

        $dataImg = $request->image;
        $subido="";
        $urlGuardar="";
        $user = Auth::user();
        $agent = Agent::where('user_id', $user->id)->first();
        $client = Customers::where('user_id', $user->id)->first();

        if ($request->hasFile('image')) {
            $nombre = $dataImg->getClientOriginalName();
            $extension=$dataImg->getClientOriginalExtension();
            $nuevoNombre = $nombre.".".$extension;
            $subido = Storage::disk('perfil')->put($nombre, \File::get($dataImg));
            if($subido){
                $urlGuardar = 'img/perfil/'.$nombre;
            }
        }

        $dataUser = null;

        if ($agent) {
            $agent->img = $urlGuardar;
            $agent->save();
        }

        if ($client) {
            $client->img = $urlGuardar;
            $client->save();
        }

    }

    public function changePassword(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        $user = Auth::user();
        $user = User::find($user->id);
        $user->password = Hash::make($request->password);
        $user->save();

        if ($user->save()) {
            $title = "Correcto";
            $mensaje = "La contraseña se actualizó correctamente";
            $status = "success";
        } else {
            $title = "Error";
            $mensaje = "Error desconocido";
            $status = "error";
        }
        return response()->json(["title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }
}
