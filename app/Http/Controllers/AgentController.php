<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchAgentRequest;
use App\Models\Agent;
use App\Interfaces\AgentInterface;
use App\Services\AgentService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AgentController extends Controller
{
    protected $agentService;

    public function __construct(AgentService $agentService) {
        $this->agentService = $agentService;
    }

    public function index()
    {
        try {
            $data = $this->agentService->getAgentsData();
            $agents = $data->agents;
            $areas = $data->areas;
            $roles = $data->roles;
            $dataUser = $data->dataUser;
            $rouletteSpin = $data->rouletteSpin;


            return view('agent.index', compact('agents', 'areas', 'roles', 'dataUser', 'rouletteSpin'));
        } catch (Exception $e) {
            Log::error("Error al obtener agentes: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar los agentes.');
        }
        
    } 

    public function agentsPagination()
    {
        $agents = Agent::orderBy('lastname')->paginate(10);
        return view('agent.list.listAgent', compact('agents'))->render();
    }

    public function searchAgent(SearchAgentRequest $request)
    {
        $data = $this->agentService->searchAgent($request);
        return response()->json(["name" => $data['name'], "title" => $data['title'], "text" => $data['mensaje'], "status" => $data['status']]);
    }

    public function saveAgent(Request $request)
    {
        $data = $this->agentService->saveAgent($request->all());
        $dataAgents = $this->agentService->getAgentsData();
        $agents = $dataAgents->agents;
        return response()->json(["view" => view('agent.list.listAgent', compact('agents'))->render(), "title"=>$data['title'], "text"=>$data['mensaje'], "status"=>$data['status']]);
    }

    public function updateAgent(Request $request)
    {
        $resp = $this->agentService->updateAgent($request);
        $agents = Agent::orderBy('lastname')->paginate(10);
        return response()->json(["view" => view('agent.list.listAgent', compact('agents'))->render(), "resp" => $resp]);
    }

    public function cambiarEstadoAgente(Request $request)
    {
        $resp = $this->agentService->cambiarEstadoAgente($request->id, $request->status);
        $agents = Agent::orderBy('lastname')->paginate(10);
        return response()->json(["view" => view('agent.list.listAgent', compact('agents'))->render(), "resp" => $resp]);
    }

    public function eliminarAgente(Request $request)
    {
        $resp = $this->agentService->eliminarAgente($request->id);
        $agents = Agent::orderBy('lastname')->paginate(10);
        return response()->json(["view" => view('agent.list.listAgent', compact('agents'))->render(), "resp" => $resp]);
    }

    public function saveNumberTurns(Request $request)
    {
        $resp = $this->agentService->saveNumberTurns($request->id, $request->cant);
        $agents = Agent::orderBy('lastname')->paginate(10);
        return response()->json(["view" => view('agent.list.listAgent', compact('agents'))->render(), "resp" => $resp]);
    }

    public function uploadImg(Request $request)
    {
        $response = $this->agentService->uploadImg($request);
        return response()->json($response);
    }

    public function changePassword(Request $request)
    {
        $data = $this->agentService->changePassword($request);
        return response()->json($data);
    }

    public function filterAgent(Request $request) {
        $agents = $this->agentService->filterAgent($request);
        return response()->json(["view" => view('agent.list.listAgent', compact('agents'))->render()]);
    }
}
