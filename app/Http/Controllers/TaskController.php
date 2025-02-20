<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Area;
use App\Models\Customers;
use App\Models\Premio;
use App\Models\Priority;
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
        $priorities = Priority::all();
        return view('task.index', compact('premios1', 'premios2', 'dataUser', 'areas', 'rouletteSpin', 'priorities'));
    }

    public function obtenerEventos()
    {
        $eventos = Task::with('agent')->get();

        $eventos_formateados = [];
        foreach ($eventos as $evento) {
            $eventos_formateados[] = [
                'id' => $evento->id,
                'title' => $evento->agent->name . " " . $evento->agent->lastname . " - " . $evento->name,
                'start' => $evento->start,
                'end' => $evento->end,
                'backgroundColor' => $evento->priority->color,
                'borderColor' => $evento->priority->color,
            ];
        }
        return response()->json($eventos_formateados);
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
        $urlGuardar = '';
        $resp = 0;
        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();

        if ($request->hasFile('imgEvento')) {
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
            $task->start = $horaInicio;
            $task->end = $horaFin;
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
    public function saveEvent(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        $agent = Agent::where('code', $request->codAgent)->first();
        $priority = Priority::where('id', $request->priorityEvent)->first();
        $client = Customers::where('code', $request->codCustomer)->first();

        try {
            $task = new Task();
            $task->name = $request->nameEvent;
            $task->description = $request->descriptionEvent;
            $task->document = '';
            $task->timeStart = $request->desde;
            $task->timeEnd = $request->hasta;
            $task->date = $request->dateEvent;
            $task->agent_id = $agent->id;
            $task->priority_id = $priority->id;
            $task->customer_id = $client->id;
            $task->start = $request->dateEvent ." ".$request->desde;
            $task->end = $request->dateEvent ." ".$request->hasta;
            if ($task->save()) {
                $title = "Correcto";
                $mensaje = "El evento se creó correctamente";
                $status = "success";
            }
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        return response()->json(["title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEventById(Request $request)
    {
        $id = $request->id;
        $evento = Task::with('customer')->find($id);
        return response()->json($evento);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editEvent(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();
        $priority = Priority::where('id', $request->priorityEvent)->first();
        $client = Customers::where('code', $request->codCustomer)->first();

        //dd($request->idEvent);

        try {
            $task = Task::find($request->idEvent);
            $task->name = $request->nameEvent;
            $task->description = $request->descriptionEvent;
            $task->document = '';
            $task->timeStart = $request->desde;
            $task->timeEnd = $request->hasta;
            $task->date = $request->dateEvent;
            $task->agent_id = $agent->id;
            $task->priority_id = $priority->id;
            $task->customer_id = $client->id;
            $task->start = $request->dateEvent ." ".$request->desde;
            $task->end = $request->dateEvent ." ".$request->hasta;
            if ($task->save()) {
                $title = "Correcto";
                $mensaje = "El evento se modificó correctamente";
                $status = "success";
            }
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        return response()->json(["title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteEvent(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {
            $task = Task::find($request->idEvent);
            if ($task->delete()) {
                $title = "Correcto";
                $mensaje = "El evento se eliminó correctamente";
                $status = "success";
            }
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        return response()->json(["title"=>$title, "text"=>$mensaje, "status"=>$status]);
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
