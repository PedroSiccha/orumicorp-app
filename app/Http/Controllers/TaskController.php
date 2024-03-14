<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Area;
use App\Models\Customers;
use App\Models\Premio;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        $roles = $user->getRoleNames()->first();

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

        $areas = Area::where('status', 1)->get();
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        return view('task.index', compact('premios1', 'premios2', 'dataUser', 'areas', 'rouletteSpin'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function guardarTask(Request $request)
    {
        $fecha = date("Y-m-d", strtotime($request->fecha));
        $titulo = $request->titulo;
        $descripcion = $request->descripcion;
        $horaInicio = $request->horaInicio;
        $horaFin = $request->horaFin;
        $img = $request->imgEvento;
        $nomArchivo = trim($img);
        $resp = 0;
        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();

        if ($request->hasFile('imgTask')) {
            $nombre=$img->getClientOriginalName();
            $extension=$img->getClientOriginalExtension();
            $nuevoNombre=$nombre.".".$extension;
            $subido = Storage::disk('task')->put($nombre, File::get($img));
            if($subido){
                $urlGuardar='img/task/'.$nombre;
            }
        }

        try {
            $task = new Task();
            $task->name = $titulo;
            $task->description = $descripcion;
            $task->document = $urlGuardar;
            $task->timeStart = $horaInicio;
            $task->timeEnd = $horaFin;
            $task->date = $fecha;
            $task->agent_id = $agent->id;
            if ($task->save()) {
                $resp = 1;
            }
        } catch (Exception $e) {
            dd("Error: " . $e->getMessage());
        }


        return response()->json(['resp' => $resp]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
