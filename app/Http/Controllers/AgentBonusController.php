<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Agent;
use App\Models\Area;
use App\Models\BonusAgent;
use App\Models\Commission;
use App\Models\Customers;
use App\Models\ExchangeRate;
use App\Models\Percent;
use App\Models\Premio;
use App\Models\Sales;
use App\Models\Target;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $user = User::where('id', $user_id)->first();
        $roles = $user->getRoleNames()->first();

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
        if ($roles == 'ADMINISTRADOR') {
            $bonusAgent = Sales::where('status', true)
                                ->where('action_id', 2)
                                ->orWhere('action_id', 3)
                                ->orWhere('action_id', 1)
                                ->orderBy('created_at', 'desc')
                                ->get();
        } else {

            $bonusAgent = Sales::where('status', 1)
                                ->where('agent_id', $agent->id)
                                ->where(function ($query) {
                                    $query->where('action_id', 2)
                                        ->orWhere('action_id', 3)
                                        ->orWhere('action_id', 1);
                                })
                                ->orderByDesc('created_at')
                                ->get();

        }


        $target = Target::where('status', true)
                    ->where('month', date("m"))
                    ->orderBy("created_at", "asc")
                    ->first();

        if ($target == null) {
            $target = new Target();
            $target->amount = 0;
        }

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
        $rouletteSpin = $agent->number_turns ?: 0;
        $areas = Area::where('status', true)->get();

        return view('bonusAgente.index', compact('bonusAgent', 'percents', 'commissions', 'exchange_rates', 'target', 'amount', 'amountRetiro', 'premios1', 'premios2', 'dataUser', 'rouletteSpin', 'areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveBonus(Request $request)
    {
        $title = 'Error';
        $mensaje = 'Error desconocido';
        $status = 'error';

        $client_id = "";
        if ($request->dniCustomer > 0) {
            $client = Customers::where('code', $request->dniCustomer)->first();
            $client_id = $client->id;
        }

        $agent = Agent::where('user_id', Auth::user()->id)->first();

        try {
            $bonusAgent = new BonusAgent();
            $bonusAgent->date_admission = Carbon::now();
            $bonusAgent->amount = $request->amount;
            $bonusAgent->observation = $request->observation;
            $bonusAgent->status = true;
            $bonusAgent->customer_id = $client_id;
            if ($request->percent_id > 0) {
                $bonusAgent->percent_id = $request->percent_id;
            }
            if ($request->commission_id > 0) {
                $bonusAgent->commission_id = $request->commission_id;
            }
            if ($request->exchange_rate_id > 0) {
                $bonusAgent->exchange_rate_id = $request->exchange_rate_id;
            }
            $bonusAgent->agent_id = $agent->id;
            $bonusAgent->action_id = 1;
            if ($bonusAgent->save()) {
                $title = "Correcto";
                $mensaje = "Registrado correctamente";
                $status = "success";
            }
        } catch (Exception $e) {
            $title = 'Error';
            $mensaje = 'Ocurrió un error: '.$e->getMessage();
            $status = 'error';
        }


        $bonusAgent = BonusAgent::where('status', true)->orderBy('date_admission', 'desc')->get();

        return response()->json(["view"=>view('bonusAgente.list.listBonusAgent', compact('bonusAgent'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function saveRetiro(Request $request)
    {
        $agent = Agent::where('dni', $request->dni)
                        ->orWhere('code', $request->dni)
                        ->first();

        $action = new Action();

        $sale = new Sales();
        $sale->date_admission = Carbon::now();
        $sale->amount = -1*($request->amount);
        $sale->observation = $request->observation;
        $sale->status = true;
        $sale->percent = $request->percent;
        $sale->commission = $request->commission;
        $sale->exchange_rate = $request->exchange_rate;
        $sale->agent_id = $agent->id;
        $sale->action_id = 4;
        $sale->user_id = Auth::user()->id;
        if ($sale->save()) {
            $resp = 1;
        }

        $bonusAgent = BonusAgent::where('status', true)->orderBy('date_admission')->get();

        return response()->json(["view"=>view('bonusAgente.list.listBonusAgent', compact('bonusAgent'))->render(), "resp"=>$resp]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filterBonus(Request $request)
    {
        $dateInit = DateTime::createFromFormat('m/d/Y', $request->dateInit)->format('Y-m-d');
        $dateEnd = DateTime::createFromFormat('m/d/Y', $request->dateEnd)->format('Y-m-d');
        $codigo = $request->code;
        $nombre = $request->code;

        $bonusAgent = Sales::join('agents as a', 'sales.agent_id', '=', 'a.id')
                        ->where(function ($queryAction) {
                            $queryAction->where('sales.action_id', 2)->orWhere('sales.action_id', 3);
                        })
                        ->where(function ($query) use ($codigo, $nombre) {
                            $query->where('a.code', 'LIKE', '%' . $codigo . '%')
                                ->orWhere(DB::raw("CONCAT(a.name, ' ', a.lastname)"), 'LIKE', '%' . $nombre . '%');
                        })
                        ->where('a.area_id', $request->area)
                        ->whereBetween('sales.date_admission', [$dateInit, $dateEnd])
                        ->get();

        return response()->json(["view"=>view('bonusAgente.list.listBonusAgent', compact('bonusAgent'))->render()]);
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
