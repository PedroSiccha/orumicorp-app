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
            $bonusAgent = Sales::whereIn('action_id', [1, 2, 3]) // Filtra por action_id 1, 2 y 3
                                ->where('status', 1)
                                ->orderBy('created_at', 'DESC') // Ordena por fecha de admisión de forma descendente
                                ->with('action') // Carga la relación con actions (si está definida en el modelo)
                                ->get();
        } else {

            $bonusAgent = Sales::whereIn('action_id', [1, 2, 3]) // Filtra por action_id 1, 2 y 3
                                ->where('status', 1)
                                ->where('agent_id', $agent->id)
                                ->orderBy('created_at', 'DESC') // Ordena por fecha de admisión de forma descendente
                                ->with('action') // Carga la relación con actions (si está definida en el modelo)
                                ->get();

        }


        $target = Target::where('status', true)
                    ->where('month', date("m"))
                    ->orderBy("created_at", "asc")
                    ->get();

        $reportTargetMensual = $target->sum('amount');

        if ($target == null) {
            $target = new Target();
            $target->amount = 0;
        }

        $amount = DB::table('sales as s')
                    ->join('actions as a', 's.action_id', '=', 'a.id')
                    ->join('movement_types as m', 'a.movement_type_id', '=', 'm.id')
                    ->where('m.name', 'INGRESO')
                    ->where('s.status', 1) // Solo incluir ventas activas
                    ->where('a.status', 1) // Solo incluir acciones activas
                    ->whereMonth('s.date_admission', date("m")) // Filtrar solo el mes actual
                    ->value(DB::raw('COALESCE(SUM(s.amount), 0)'));

        $amountRetiro = DB::table('sales as s')
                        ->join('actions as a', 's.action_id', '=', 'a.id')
                        ->join('movement_types as m', 'a.movement_type_id', '=', 'm.id')
                        ->where('m.name', 'EGRESO')
                        ->where('s.status', 1) // Solo incluir ventas activas
                        ->where('a.status', 1) // Solo incluir acciones activas
                        ->whereMonth('s.date_admission', date("m")) // Filtrar solo el mes actual
                        ->value(DB::raw('COALESCE(SUM(s.amount), 0)'));

        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $rouletteSpin = $agent->number_turns ?: 0;
        $areas = Area::where('status', true)->get();

        return view('bonusAgente.index', compact('bonusAgent', 'percents', 'commissions', 'exchange_rates', 'target', 'amount', 'amountRetiro', 'premios1', 'premios2', 'dataUser', 'rouletteSpin', 'areas', 'reportTargetMensual'));
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

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        $roles = $user->getRoleNames()->first();

        $client_id = "";
        if ($request->dniCustomer > 0) {
            $client = Customers::where('code', $request->dniCustomer)->first();
            $client_id = $client->id;
        }

        $codeAgt = $request->dniAgent;
        $amount = $request->amount;
        $observation = $request->observation;

        $agent = Agent::where('code_voiso', $codeAgt)->first();

        try {
            $bonusAgent = new BonusAgent();
            $bonusAgent->date_admission = Carbon::now();
            $bonusAgent->amount = $amount;
            $bonusAgent->observation = $observation;
            $bonusAgent->status = true;
            // $bonusAgent->customer_id = $client_id;
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

                $sale = new Sales();
                $sale->date_admission = Carbon::now();
                $sale->amount = $amount;
                $sale->observation = $observation;
                $sale->status = true;
                $sale->agent_id = $agent->id;
                $sale->action_id = 2;
                $sale->user_id = Auth::user()->id;
                if ($sale->save()) {
                    $title = "Correcto";
                    $mensaje = "Registrado correctamente";
                    $status = "success";
                }
            }
        } catch (Exception $e) {
            $title = 'Error';
            $mensaje = 'Ocurrió un error: '.$e->getMessage();
            $status = 'error';
        }

        if ($roles == 'ADMINISTRADOR') {
            $bonusAgent = Sales::whereIn('action_id', [1, 2, 3]) // Filtra por action_id 1, 2 y 3
                                ->where('status', 1)
                                ->orderBy('created_at', 'DESC') // Ordena por fecha de admisión de forma descendente
                                ->with('action') // Carga la relación con actions (si está definida en el modelo)
                                ->get();
        } else {

            $bonusAgent = Sales::whereIn('action_id', [1, 2, 3]) // Filtra por action_id 1, 2 y 3
                                ->where('status', 1)
                                ->where('agent_id', $agent->id)
                                ->orderBy('created_at', 'DESC') // Ordena por fecha de admisión de forma descendente
                                ->with('action') // Carga la relación con actions (si está definida en el modelo)
                                ->get();

        }


        //$bonusAgent = BonusAgent::where('status', true)->orderBy('date_admission', 'desc')->get();

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
