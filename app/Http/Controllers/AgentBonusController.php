<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Agent;
use App\Models\BonusAgent;
use App\Models\Commission;
use App\Models\Customers;
use App\Models\ExchangeRate;
use App\Models\Percent;
use App\Models\Premio;
use App\Models\Sales;
use App\Models\Target;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentBonusController extends Controller
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

        $dataUser = null;

        if ($agent) {
            $dataUser = $agent;
        }

        if ($client) {
            $dataUser = $client;
        }

        $percents = Percent::where('status', true)->get();
        $commissions = Commission::where('status', true)->get();
        $exchange_rates = ExchangeRate::where('status', true)->get();
        $bonusAgent = BonusAgent::where('status', true)->orderBy('date_admission')->take(10)->get();
        $target = Target::where('status', true)
                    ->where('mount', date("m"))
                    ->orderBy("created_at", "asc")
                    ->first();

        $amount = Sales::join('actions', 'sales.action_id', '=', 'actions.id')
              ->where('actions.movement_type_id', 1)
              ->where('actions.status', 1)
              ->where('sales.status', 1)
              ->whereMonth('sales.created_at', date("m"))
              ->sum('sales.amount');

        $amountRetiro = Sales::join('actions', 'sales.action_id', '=', 'actions.id')
              ->where('actions.movement_type_id', 2)
              ->where('actions.status', 1)
              ->where('sales.status', 1)
              ->whereMonth('sales.created_at', date("m"))
              ->sum('sales.amount');

        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();

        return view('bonusAgente.index', compact('bonusAgent', 'percents', 'commissions', 'exchange_rates', 'target', 'amount', 'amountRetiro', 'premios1', 'premios2', 'dataUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveBonus(Request $request)
    {
        $client = Customers::where('dni', $request->dniCustomer)
                  ->orWhere('code', $request->dniCustomer)
                  ->first();

        $agent = Agent::where('user_id', Auth::user()->id)->first();

        $bonusAgent = new BonusAgent();
        $bonusAgent->date_admission = Carbon::now();
        $bonusAgent->amount = $request->amount;
        $bonusAgent->observation = $request->observation;
        $bonusAgent->status = true;
        $bonusAgent->customer_id = $client->id;
        $bonusAgent->percent_id = $request->percent_id;
        $bonusAgent->commission_id = $request->commission_id;
        $bonusAgent->exchange_rate_id = $request->exchange_rate_id;
        $bonusAgent->agent_id = $agent->id;
        $bonusAgent->action_id = 1;
        if ($bonusAgent->save()) {
            $resp = 1;
        }

        $bonusAgent = BonusAgent::where('status', true)->orderBy('date_admission')->take(10)->get();

        return response()->json(["view"=>view('bonusAgente.list.listBonusAgent', compact('bonusAgent'))->render(), "resp"=>$resp]);
    }

    public function saveRetiro(Request $request)
    {
        $agent = Agent::where('dni', $request->dniAgent)
                  ->orWhere('code', $request->dniAgent)
                  ->first();

        $action = new Action();

        $sale = new Sales();
        $sale->date_admission = Carbon::now();
        $sale->amount = $request->amountRetiro;
        $sale->observation = $request->observation;
        $sale->status = true;
        $sale->customer_id = 0;
        $sale->percent_id = $request->percent_id;
        $sale->commission_id = $request->commission_id;
        $sale->exchange_rate_id = $request->exchange_rate_id;
        $sale->agent_id = 1;
        $sale->action_id = 2;
        if ($sale->save()) {
            $resp = 1;
        }

        $bonusAgent = BonusAgent::where('status', true)->orderBy('date_admission')->take(10)->get();

        return response()->json(["view"=>view('bonusAgente.list.listBonusAgent', compact('bonusAgent'))->render(), "resp"=>$resp]);
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
