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

    // public function agentsPagination()
    // {
    //     $agents = Agent::orderBy('created_at', 'desc')->paginate(10);
    //     return view('agent.list.listAgent', compact('agents'))->render();
    // }
    public function agentsPagination(Request $request)
    {
        $query = Agent::query();

        if ($request->has('area') && !empty($request->area)) {
            $query->where('area_id', $request->area);
        }

        if ($request->has('code') && !empty($request->code)) {
            $query->where(function ($q) use ($request) {
                $q->whereRaw('CONCAT(name, " ", lastname) LIKE ?', ['%' . $request->code . '%'])
                ->orWhere('code_voiso', 'like', '%' . $request->code . '%')
                ->orWhere('code', 'like', '%' . $request->code . '%');
            });
        }

        if ($request->has('dateInit') && !empty($request->dateInit)) {
            $query->whereDate('created_at', '>=', $request->dateInit);
        }

        if ($request->has('dateEnd') && !empty($request->dateEnd)) {
            $query->whereDate('created_at', '<=', $request->dateEnd);
        }

        $agents = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('agent.list.listAgent', compact('agents'))->render();
    }


    public function searchAgent(Request $request)
    {
        $data = $this->agentService->searchAgent($request);
        return response()->json(["name" => $data['name'], "title" => $data['title'], "text" => $data['mensaje'], "status" => $data['status']]);
    }

    public function saveAgent(Request $request)
    {
        $data = $this->agentService->saveAgent($request);
        $agents = Agent::orderBy('created_at', 'desc')->paginate(10);
        return response()->json(["view" => view('agent.list.listAgent', compact('agents'))->render(), "title"=>$data['title'], "text"=>$data['mensaje'], "status"=>$data['status']]);
    }

    public function updateAgent(Request $request)
    {
        $resp = $this->agentService->updateAgent($request);
        $agents = Agent::orderBy('created_at', 'desc')->paginate(10);
        return response()->json(["view" => view('agent.list.listAgent', compact('agents'))->render(), "resp" => $resp]);
    }

    public function cambiarEstadoAgente(Request $request)
    {
        $resp = $this->agentService->cambiarEstadoAgente($request->id, $request->status);
        $agents = Agent::orderBy('created_at', 'desc')->paginate(10);
        return response()->json(["view" => view('agent.list.listAgent', compact('agents'))->render(), "resp" => $resp]);
    }

    public function eliminarAgente(Request $request)
    {
        $resp = $this->agentService->eliminarAgente($request->id);
        $agents = Agent::orderBy('created_at', 'desc')->paginate(10);
        return response()->json(["view" => view('agent.list.listAgent', compact('agents'))->render(), "resp" => $resp]);
    }

    public function saveNumberTurns(Request $request)
    {
        $resp = $this->agentService->saveNumberTurns($request->id, $request->cant);
        $agents = Agent::orderBy('created_at', 'desc')->paginate(10);
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

    public function search(Request $request)
    {
        $query = $request->get('term', '');

        $agents = Agent::query()
            ->select('id', 'name', 'lastname', 'code_voiso')
            ->where('status', 1)
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('name', 'LIKE', "%{$query}%")
                        ->orWhere('lastname', 'LIKE', "%{$query}%")
                        ->orWhere('code_voiso', 'LIKE', "%{$query}%");
                });
            })
            ->limit(20)
            ->get();

        return response()->json([
            'results' => $agents->map(function ($agent) {
                return [
                    'id' => $agent->id,
                    'text' => "{$agent->name} {$agent->lastname} ({$agent->code_voiso})"
                ];
            })
        ]);
    }


}
