<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Interfaces\AgentInterface;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    protected $agentService;

    public function __construct(AgentInterface $agentService) {
        $this->agentService = $agentService;
    }

    public function index()
    {
        $data = $this->agentService->index();
        return view('agent.index', $data);
    }

    public function agentsPagination()
    {
        $agents = Agent::orderBy('lastname')->paginate(10);
        return view('agent.list.listAgent', compact('agents'))->render();
    }

    public function searchAgent(Request $request)
    {
        $data = $this->agentService->searchAgent($request);
        return response()->json(["name" => $data['name'], "title" => $data['title'], "text" => $data['mensaje'], "status" => $data['status']]);
    }

    public function saveAgent(Request $request)
    {
        $resp = $this->agentService->saveAgent($request);
        $agents = Agent::orderBy('lastname')->paginate(10);
        return response()->json(["view" => view('agent.list.listAgent', compact('agents'))->render(), "resp" => $resp]);
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
        $this->agentService->uploadImg($request);
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
