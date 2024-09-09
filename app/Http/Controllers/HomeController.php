<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Assistance;
use App\Models\Customers;
use App\Models\Premio;
use App\Models\Provider;
use App\Models\Sales;
use App\Models\User;
use Carbon\Carbon;
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
        $rouletteSpin = 0;
        $dateIn = null;
        $agent = Agent::where('user_id', $user_id)->first();
        $client = Customers::where('user_id', $user_id)->first();
        if ($agent) {
            $rouletteSpin = $agent->number_turns ?: 0;
        }


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

        if ($agent) {
            $dateIn = Assistance::where('date', date('Y-m-d'))->where('type', 'IN')->where('agent_id', $agent->id)->first();
        }

        $cantClientsRegisterProvider = 0;
        $percentClientsRegisterProvider = 0;
        $cantClientsActiveProvider = 0;
        $percentClientsActiveProvider = 0;
        $cantClientsProvider = 0;
        $listClientsProvider = [];

        $user = User::where('id', $user_id)->first();
        $roles = $user->getRoleNames()->first();

        if ($roles == 'PROVEEDOR') {
            $providerId = Provider::where('user_id', $user_id)->first()->id;
            $cantClientsRegisterProvider = Customers::where('id_provider', $providerId)->whereMonth('date_admission', Carbon::now()->month)->whereYear('date_admission', Carbon::now()->year)->count();
            $cantClientsActiveProvider = Customers::where('id_provider', $providerId)->whereHas('deposits', function($query) {
                                                        $query->whereMonth('date', Carbon::now()->month)
                                                            ->whereYear('date', Carbon::now()->year);
                                                    })->distinct('id')->count();
            $cantClientsProvider = Customers::where('id_provider', $providerId)->whereYear('date_admission', Carbon::now()->year)->count();
            if ($cantClientsRegisterProvider > 0) {
                $percentClientsActiveProvider = round(($cantClientsActiveProvider / $cantClientsRegisterProvider) * 100, 2);
            }
            if ($cantClientsProvider > 0) {
                $percentClientsRegisterProvider = round(($cantClientsRegisterProvider / $cantClientsProvider) * 100, 2);
            }
            $listClientsProvider = Customers::where('id_provider', $providerId)->whereMonth('date_admission', Carbon::now()->month)->whereYear('date_admission', Carbon::now()->year)->with('statusCustomer')->get();
        }


        return view('home', compact('premios1', 'premios2', 'dataUser', 'rouletteSpin', 'cantAgents', 'cantClients', 'montoVenta', 'montoRetencion', 'montosPorAgente', 'dateIn', 'cantClientsRegisterProvider', 'cantClientsActiveProvider', 'cantClientsProvider', 'listClientsProvider', 'percentClientsActiveProvider', 'percentClientsRegisterProvider'));
    }
}
