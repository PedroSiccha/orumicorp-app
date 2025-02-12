<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Customers;
use App\Models\Premio;
use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GestionRuletaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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

        $premios = Premio::where('status', true)->get();
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        return view('gestionRuleta.index', compact('premios', 'premios1', 'premios2', 'dataUser', 'rouletteSpin'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function savePremio(Request $request)
    {
        $resp = 0;
        $type = 1;

        if ($request->orden < 5) {
            $type = 1;
        } else {
            $type = 2;
        }


        $premios = Premio::where('order', $request->orden)->first();
        $premios->name = $request->nombre;
        $premios->description = $request->descripcion;
        $premios->value = $request->valor;
        $premios->status = 1;
        $premios->order = $request->orden;
        $premios->type = $type;
        if ($premios->save()) {
            $resp = 1;
        }

        $premios = Premio::where('status', true)->get();

        return response()->json(["view"=>view('gestionRuleta.components.tabPremio', compact('premios'))->render(), "resp"=>$resp]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateGiro(Request $request)
    {
        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();

        $cant_giro = $agent->number_turns;
        $new_giro = 0;
        if ($cant_giro > 0) {
            $new_giro = $cant_giro - 1;
        }
        $agent->number_turns = $new_giro;
        $agent->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPremio(Request $request)
    {
        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();
        $premio = Premio::where('order', $request->premio)->first();

        $sale = new Sales();
        $sale->date_admission = Carbon::now();
        $sale->status = true;
        $sale->observation = "Giro de Ruleta";
        $sale->commission = $premio->value;
        $sale->agent_id = $agent->id;
        $sale->action_id = '2';
        $sale->user_id = $user_id;
        $sale->save();
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
