<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Assistance;
use App\Models\Customers;
use App\Models\Premio;
use App\Models\Sales;
use App\Models\Target;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function perfilUsuario($id)
    {

        $agent = Agent::where('user_id', $id)->first();
        $client = Customers::where('user_id', $id)->first();
        $rouletteSpin = 0;

        if ($agent->number_turns) {
            $rouletteSpin = $agent->number_turns;
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

        $dateIn = Assistance::where('date', date('Y-m-d'))->where('type', 'IN')->where('agent_id', $agent->id)->first();
        $dateBreakIn = Assistance::where('date', date('Y-m-d'))->where('type', 'IN-BREAK')->where('agent_id', $agent->id)->first();
        $dateBreakOut = Assistance::where('date', date('Y-m-d'))->where('type', 'OUT-BREAK')->where('agent_id', $agent->id)->first();
        $dateOut = Assistance::where('date', date('Y-m-d'))->where('type', 'OUT')->where('agent_id', $agent->id)->first();
        $clients = Customers::where('agent_id', $agent->id)->paginate(5, ['*'], 'clients_page')->withQueryString();
        $targets = Target::select('id', 'amount', 'agent_id')
                        ->selectRaw("MONTHNAME(CONCAT('2024-', month, '-01')) AS mes")
                        ->where('agent_id', $agent->id  )
                        ->paginate(5, ['*'], 'targets_page')->withQueryString();

        $sales = Sales::select('sales.*', 'c.name', 'c.lastname')
                        ->join('customers as c', 'sales.customer_id', '=', 'c.id')
                        ->where('sales.agent_id', $agent->id)
                        ->paginate(5, ['*'], 'sales_page')->withQueryString();

        $targetMensual = Target::where('status', true)
                        ->where('month', date("m"))
                        ->where('agent_id', $agent->id)
                        ->orderBy("created_at", "asc")
                        ->first();

        $ingresosActuales = Sales::join('actions', 'sales.action_id', '=', 'actions.id')
                                    ->where('actions.movement_type_id', 1)
                                    ->where('actions.status', 1)
                                    ->where('sales.status', 1)
                                    ->where('sales.agent_id', $agent->id)
                                    ->whereMonth('sales.created_at', date("m"))
                                    ->sum('sales.amount');

        $amountRetiro = Sales::join('actions', 'sales.action_id', '=', 'actions.id')
                            ->where('actions.movement_type_id', 2)
                            ->where('actions.status', 1)
                            ->where('sales.status', 1)
                            ->where('sales.agent_id', $agent->id)
                            ->whereMonth('sales.created_at', date("m"))
                            ->sum('sales.amount');

        return view('profile.index', compact('premios1', 'premios2', 'dataUser', 'rouletteSpin', 'dateIn', 'dateBreakIn', 'dateBreakOut', 'dateOut', 'clients', 'targets', 'sales', 'targetMensual', 'ingresosActuales', 'amountRetiro'));
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
