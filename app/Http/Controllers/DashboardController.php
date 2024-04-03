<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Customers;
use App\Models\Premio;
use App\Models\Sales;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /*
        $permission = Permission::create(['name' => 'Ver Agentes']);
        $permission = Permission::create(['name' => 'Crear Agente']);
        $permission = Permission::create(['name' => 'Estado Agente']);
        $permission = Permission::create(['name' => 'Editar Agente']);
        $permission = Permission::create(['name' => 'Eliminar Agente']);
        $permission = Permission::create(['name' => 'Ver Area']);
        $permission = Permission::create(['name' => 'Crear Area']);
        $permission = Permission::create(['name' => 'Estado Area']);
        $permission = Permission::create(['name' => 'Editar Area']);
        $permission = Permission::create(['name' => 'Eliminar Area']);
        $permission = Permission::create(['name' => 'Ver Cliente']);
        $permission = Permission::create(['name' => 'Crear Cliente']);
        $permission = Permission::create(['name' => 'Estado Cliente']);
        $permission = Permission::create(['name' => 'Editar Cliente']);
        $permission = Permission::create(['name' => 'Eliminar Cliente']);
        $permission = Permission::create(['name' => 'Ver Ventas']);
        $permission = Permission::create(['name' => 'Registrar Ventas']);
        $permission = Permission::create(['name' => 'Ver Bonus']);
        $permission = Permission::create(['name' => 'Registrar Descuento']);
        $permission = Permission::create(['name' => 'Registrar Bonus']);
        $permission = Permission::create(['name' => 'Ver Totales']);
        $permission = Permission::create(['name' => 'Ver Today']);
        $permission = Permission::create(['name' => 'Filtrar Today']);
        $permission = Permission::create(['name' => 'Filtrar Area Today']);
        $permission = Permission::create(['name' => 'Ver Gestión Ruleta']);
        $permission = Permission::create(['name' => 'Registrar Premio Ruleta']);
        $permission = Permission::create(['name' => 'Ver Part Time']);
        $permission = Permission::create(['name' => 'Registrar Asistencia']);
        $permission = Permission::create(['name' => 'Filtrar Historial de Asistencias']);
        $permission = Permission::create(['name' => 'Ver Historial de Asistencias']);
        $permission = Permission::create(['name' => 'Ver Seguridad']);
        $permission = Permission::create(['name' => 'Registrar Roles']);
        $permission = Permission::create(['name' => 'Ver Permisos de Roles']);
        $permission = Permission::create(['name' => 'Asignar Permisos']);
        $permission = Permission::create(['name' => 'Ver Auditorio']);
        $user = User::find(1);
        $role = Role::find(1);
        $user->assignRole($role);
        */

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        $roles = $user->getRoleNames()->first();

        $agent = Agent::where('user_id', $user_id)->first();
        $client = Customers::where('user_id', $user_id)->first();
        $rouletteSpin = $agent->number_turns ?: 0;

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $previousMonth = Carbon::now()->subMonth()->month;
        $previousYear = Carbon::now()->subMonth()->year;

        $dataUser = null;

        if ($agent) {
            $dataUser = $agent;
        }

        if ($client) {
            $dataUser = $client;
        }

        //$role = Role::create(['name' => 'ADMINISTRADOR']);
        //$permission = ModelsPermission::create(['name' => 'Ver Agentes']);
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();

        if ($roles == 'ADMINISTRADOR') {
            $sales = Sales::where('status', true)
                        ->where('action_id', 1)
                        ->where(function ($query) use ($currentMonth, $currentYear, $previousMonth, $previousYear) {
                            $query->whereYear('date_admission', $currentYear)->whereMonth('date_admission', $currentMonth)
                                    ->orWhere(function ($query) use ($previousMonth, $previousYear) {
                                        $query->whereYear('date_admission', $previousYear)->whereMonth('date_admission', $previousMonth);
                                    });
                        })
                        ->orderBy('date_admission', 'desc')
                        ->get();
        } else {
            $sales = Sales::where('status', true)
                        ->where('action_id', 1)
                        ->where('agent_id', $agent->id)
                        ->where(function ($query) use ($currentMonth, $currentYear, $previousMonth, $previousYear) {
                            $query->whereYear('date_admission', $currentYear)->whereMonth('date_admission', $currentMonth)
                                    ->orWhere(function ($query) use ($previousMonth, $previousYear) {
                                        $query->whereYear('date_admission', $previousYear)->whereMonth('date_admission', $previousMonth);
                                    });
                        })
                        ->orderBy('date_admission', 'desc')
                        ->get();
        }


        $totalAmount = $sales->sum('amount');

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

        return view('tablero.index', compact('premios1', 'premios2', 'dataUser', 'rouletteSpin', 'sales', 'totalAmount', 'cantAgents', 'cantClients', 'montoVenta', 'montoRetencion', 'montosPorAgente'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
