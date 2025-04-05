<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchAgentRequest;
use App\Models\Agent;
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
            $agents = $data['agents'];
            $areas = $data['areas'];
            $roles = $data['roles'];
            $rouletteSpin = $data['rouletteSpin'];
            $dataUser = $data['dataUser'];
            return view('agent.index', compact('agents', 'areas', 'roles', 'rouletteSpin', 'dataUser'));

        } catch (Exception $e) {
            Log::error("Error al obtener agentes: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar los agentes.');
        }
    }

<<<<<<< HEAD
    // public function agentsPagination()
    // {
    //     $agents = Agent::orderBy('created_at', 'desc')->paginate(10);
    //     return view('agent.list.listAgent', compact('agents'))->render();
    // }
    public function agentsPagination(Request $request)
=======
 

    public function agentsPagination()
>>>>>>> feature/fix-presentation
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

<<<<<<< HEAD

    public function searchAgent(Request $request)
=======
    public function searchAgent(SearchAgentRequest $request)
>>>>>>> feature/fix-presentation
    {
        $data = $this->agentService->searchAgent($request);
        return response()->json(["name" => $data['name'], "title" => $data['title'], "text" => $data['mensaje'], "status" => $data['status']]);
    }

    public function saveAgent(Request $request)
    {
<<<<<<< HEAD
        $data = $this->agentService->saveAgent($request);
        $agents = Agent::orderBy('created_at', 'desc')->paginate(10);
=======
        $data = $this->agentService->saveAgent($request->all());
        $dataAgents = $this->agentService->getAgentsData();
>>>>>>> feature/fix-presentation
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

    public function searchAjax(Request $request)
    {
        $search = $request->get('q');

        $agents = Agent::where('status', true)
            ->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                    ->orWhere('lastname', 'LIKE', "%$search%")
                    ->orWhere('code', 'LIKE', "%$search%")
                    ->orWhere('code_voiso', 'LIKE', "%$search%");
            })
            ->limit(15)
            ->get();

        $results = $agents->map(function ($agent) {
            return [
                'id' => $agent->id,
                'text' => "{$agent->name} {$agent->lastname} ({$agent->code})",
            ];
        });

        return response()->json($results);
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
