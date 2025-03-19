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
use App\Services\TaskService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{

    protected $taskService;

    public function __construct(TaskService $taskService) {
        $this->taskService = $taskService;
    }
    
    public function index()
    {
        try {
            $data = $this->taskService->getTaskData();
            $areas = $data->areas;
            $rouletteSpin = $data->rouletteSpin;
            $priorities = $data->priorities;
            return view('task.index', compact('premios1', 'premios2', 'dataUser', 'areas', 'rouletteSpin', 'priorities'));
        } catch (Exception $e) {
            Log::error("Error en TaskController: " . $e->getMessage());
        }
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
        try {
            $data = $this->taskService->saveTask($request);
            return response()->json($data);
        } catch (Exception $e) {
            Log::error("Error en TaskController: " . $e->getMessage());
        }
    }

    public function saveEvent(Request $request)
    {
        try {
            $data = $this->taskService->saveEvent($request);
            return response()->json($data);
        } catch (Exception $e) {
            Log::error("Error en TaskController: " . $e->getMessage());
        }
    }

    public function getEventById(Request $request)
    {
        try {
            $data = $this->taskService->getEventById($request);
            return response()->json($data);
        } catch (Exception $e) {
            Log::error("Error en TaskController: " . $e->getMessage());
        }
    }

    public function editEvent(Request $request)
    {
        try {
            $data = $this->taskService->editEvent($request);
            return response()->json($data);
        } catch (Exception $e) {
            Log::error("Error en TaskController: " . $e->getMessage());
        }
    }

    public function deleteEvent(Request $request)
    {
        try {
            $data = $this->taskService->deleteEvent($request);
            return response()->json($data);
        } catch (Exception $e) {
            Log::error("Error en TaskController: " . $e->getMessage());
        }
    }

}
