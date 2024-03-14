<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Assistance;
use App\Models\Customers;
use App\Models\Premio;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
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

        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $agents = Agent::get();
        $clients = Customers::get();
        $cantAgents = count($agents);
        $cantClients = count($clients);

        $montoVenta = Sales::join('agents', 'sales.agent_id', '=', 'agents.id')
                            ->where('agents.area_id', 1)
                            ->sum('sales.amount');

        $montoRetencion = Sales::join('agents', 'sales.agent_id', '=', 'agents.id')
                                ->where('agents.area_id', 2)
                                ->sum('sales.amount');

        $montosPorAgente = Sales::selectRaw('SUM(sales.amount) AS monto, agents.name, agents.lastname, areas.name AS area')
                                ->join('agents', 'sales.agent_id', '=', 'agents.id')
                                ->join('areas', 'agents.area_id', '=', 'areas.id')
                                ->groupBy('agents.id')
                                ->orderBy('monto', 'desc')
                                ->take(10)
                                ->get();

        $dateIn = Assistance::where('date', date('Y-m-d'))->where('type', 'IN')->where('agent_id', $agent->id)->first();

        return view('home', compact('premios1', 'premios2', 'dataUser', 'rouletteSpin', 'cantAgents', 'cantClients', 'montoVenta', 'montoRetencion', 'montosPorAgente', 'dateIn'));
    }
}
