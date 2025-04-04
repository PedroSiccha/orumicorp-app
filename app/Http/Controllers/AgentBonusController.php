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
    // public function index()
    // {
    //     $user_id = Auth::user()->id;
    //     $user = User::where('id', $user_id)->first();
    //     $roles = $user->getRoleNames()->first();
    //     // dd($roles);

    //     $agent = Agent::where('user_id', $user_id)->first();
    //     $client = Customers::where('user_id', $user_id)->first();

    //     $dataUser = null;

    //     if ($agent) {
    //         $dataUser = $agent;
    //     }

    //     if ($client) {
    //         $dataUser = $client;
    //     }

    //     $percents = Percent::where('status', true)->get();
    //     $commissions = Commission::where('status', true)->get();
    //     $exchange_rates = ExchangeRate::where('status', true)->get();
    //     if ($roles == 'ADMINISTRADOR') {
    //         $bonusAgent = Sales::whereIn('action_id', [1, 2, 3, 4]) // Filtra por action_id 1, 2 y 3
    //                             ->where('status', 1)
    //                             ->orderBy('created_at', 'DESC') // Ordena por fecha de admisión de forma descendente
    //                             ->with('action') // Carga la relación con actions (si está definida en el modelo)
    //                             ->paginate(10);

    //         $target = Target::where('status', true)
    //                         ->where('month', date("m"))
    //                         ->orderBy("created_at", "asc")
    //                         ->get();

    //         $amount = DB::table('sales as s')
    //                     ->join('actions as a', 's.action_id', '=', 'a.id')
    //                     ->join('movement_types as m', 'a.movement_type_id', '=', 'm.id')
    //                     ->where('m.name', 'INGRESO')
    //                     ->where('s.status', 1) // Solo incluir ventas activas
    //                     ->where('a.status', 1) // Solo incluir acciones activas
    //                     ->whereMonth('s.date_admission', date("m")) // Filtrar solo el mes actual
    //                     ->value(DB::raw('COALESCE(SUM(s.amount), 0)'));
    
    //         $amountRetiro = DB::table('sales as s')
    //                             ->join('actions as a', 's.action_id', '=', 'a.id')
    //                             ->join('movement_types as m', 'a.movement_type_id', '=', 'm.id')
    //                             ->where('m.name', 'EGRESO')
    //                             ->where('s.status', 1) // Solo incluir ventas activas
    //                             ->where('a.status', 1) // Solo incluir acciones activas
    //                             ->whereMonth('s.date_admission', date("m")) // Filtrar solo el mes actual
    //                             ->value(DB::raw('COALESCE(SUM(s.amount), 0)'));

    //     } else {

    //         $bonusAgent = Sales::whereIn('action_id', [1, 2, 3, 4]) // Filtra por action_id 1, 2 y 3
    //                             ->where('status', 1)
    //                             ->where('agent_id', $agent->id)
    //                             ->orderBy('created_at', 'DESC') // Ordena por fecha de admisión de forma descendente
    //                             ->with('action') // Carga la relación con actions (si está definida en el modelo)
    //                             ->paginate(10);

    //         $target = Target::where('status', true)
    //                             ->where('month', date("m"))
    //                             ->where('agent_id', $agent->id)
    //                             ->orderBy("created_at", "asc")
    //                             ->get();

    //         $amount = DB::table('sales as s')
    //                     ->join('actions as a', 's.action_id', '=', 'a.id')
    //                     ->join('movement_types as m', 'a.movement_type_id', '=', 'm.id')
    //                     ->where('m.name', 'INGRESO')
    //                     ->where('s.status', 1) // Solo incluir ventas activas
    //                     ->where('a.status', 1) // Solo incluir acciones activas
    //                     ->where('s.agent_id', $agent->id)
    //                     ->whereMonth('s.date_admission', date("m")) // Filtrar solo el mes actual
    //                     ->value(DB::raw('COALESCE(SUM(s.amount), 0)'));
    
    //         $amountRetiro = DB::table('sales as s')
    //                             ->join('actions as a', 's.action_id', '=', 'a.id')
    //                             ->join('movement_types as m', 'a.movement_type_id', '=', 'm.id')
    //                             ->where('m.name', 'EGRESO')
    //                             ->where('s.status', 1) // Solo incluir ventas activas
    //                             ->where('a.status', 1) // Solo incluir acciones activas
    //                             ->where('s.agent_id', $agent->id)
    //                             ->whereMonth('s.date_admission', date("m")) // Filtrar solo el mes actual
    //                             ->value(DB::raw('COALESCE(SUM(s.amount), 0)'));

    //     }

    //     $reportTargetMensual = $target->sum('amount');
    //     $amountPending = $amount + $amountRetiro;

    //     if ($target == null) {
    //         $target = new Target();
    //         $target->amount = 0;
    //     }

    //     $premios1 = Premio::where('status', true)->where('type', 1)->get();
    //     $premios2 = Premio::where('status', true)->where('type', 2)->get();
    //     $rouletteSpin = $agent->number_turns ?: 0;
    //     $areas = Area::where('status', true)->get();
    //     $bonusAgent = $this->getFilteredBonus();

    //     return view('bonusAgente.index', compact('bonusAgent', 'percents', 'commissions', 'exchange_rates', 'target', 'amount', 'amountRetiro', 'premios1', 'premios2', 'dataUser', 'rouletteSpin', 'areas', 'reportTargetMensual', 'amountPending'));
    // }

    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $roles = $user->getRoleNames()->first();
        $agent = Agent::where('user_id', $user->id)->first();

        $dateInit = $request->input('dateInit') ?? now()->startOfYear()->format('d/m/Y');
        $dateEnd = $request->input('dateEnd') ?? now()->format('d/m/Y');

        try {
            $dateInitFormatted = DateTime::createFromFormat('d/m/Y', $dateInit)->format('Y-m-d');
            $dateEndFormatted = DateTime::createFromFormat('d/m/Y', $dateEnd)->format('Y-m-d');
        } catch (Exception $e) {
            $dateInitFormatted = now()->startOfYear()->format('Y-m-d');
            $dateEndFormatted = now()->format('Y-m-d');
        }

        $query = Sales::with(['agent.area', 'action'])
            ->whereIn('action_id', [1, 2, 3, 4])
            ->where('status', 1)
            ->whereBetween('date_admission', [$dateInitFormatted, $dateEndFormatted]);

        if ($roles !== 'ADMINISTRADOR' && $agent) {
            $query->where('agent_id', $agent->id);
        }

        $bonusAgent = $query->orderByDesc('date_admission')->paginate(10);

        $targetQuery = Target::where('status', true)->where('month', date('m'));
        if ($roles !== 'ADMINISTRADOR' && $agent) {
            $targetQuery->where('agent_id', $agent->id);
        }
        $target = $targetQuery->get();

        $reportTargetMensual = $target->sum('amount');

        $amountIngreso = DB::table('sales as s')
            ->join('actions as a', 's.action_id', '=', 'a.id')
            ->join('movement_types as m', 'a.movement_type_id', '=', 'm.id')
            ->where('m.name', 'INGRESO')
            ->where('s.status', 1)
            ->where('a.status', 1)
            ->whereBetween('s.date_admission', [$dateInitFormatted, $dateEndFormatted]);

        $amountEgreso = DB::table('sales as s')
            ->join('actions as a', 's.action_id', '=', 'a.id')
            ->join('movement_types as m', 'a.movement_type_id', '=', 'm.id')
            ->where('m.name', 'EGRESO')
            ->where('s.status', 1)
            ->where('a.status', 1)
            ->whereBetween('s.date_admission', [$dateInitFormatted, $dateEndFormatted]);

        if ($roles !== 'ADMINISTRADOR' && $agent) {
            $amountIngreso->where('s.agent_id', $agent->id);
            $amountEgreso->where('s.agent_id', $agent->id);
        }

        $amount = $amountIngreso->value(DB::raw('COALESCE(SUM(s.amount), 0)'));
        $amountRetiro = $amountEgreso->value(DB::raw('COALESCE(SUM(s.amount), 0)'));

        $amountPending = $reportTargetMensual - $amount;

        $dataUser = $agent ?? null;
        $rouletteSpin = $agent->number_turns ?? 0;

        return view('bonusAgente.index', [
            'bonusAgent' => $bonusAgent,
            'percents' => Percent::where('status', true)->get(),
            'commissions' => Commission::where('status', true)->get(),
            'exchange_rates' => ExchangeRate::where('status', true)->get(),
            'target' => $target,
            'amount' => $amount,
            'amountRetiro' => $amountRetiro,
            'amountPending' => $amountPending,
            'premios1' => Premio::where('status', true)->where('type', 1)->get(),
            'premios2' => Premio::where('status', true)->where('type', 2)->get(),
            'areas' => Area::where('status', true)->get(),
            'reportTargetMensual' => $reportTargetMensual,
            'dataUser' => $dataUser,
            'rouletteSpin' => $rouletteSpin,
            'dateInit' => $dateInit,
            'dateEnd' => $dateEnd,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function saveBonus(Request $request)
    {
        $codeAgent = $request->dniAgent;
        $amount = $request->amount;
        $observation = $request->observation;

        $user = Auth::user();
        $agent = Agent::where('code_voiso', $codeAgent)->first();

        if (!$agent) {
            return response()->json([
                'title' => 'Error',
                'text' => 'Agente no encontrado.',
                'status' => 'error'
            ]);
        }

        try {
            // Guardar en BonusAgent
            $bonus = new BonusAgent();
            $bonus->date_admission = Carbon::now();
            $bonus->amount = $amount;
            $bonus->observation = $observation;
            $bonus->status = 1;
            $bonus->agent_id = $agent->id;
            $bonus->action_id = 2; // Acción: BONO
            $bonus->save();

            // Guardar en Sales
            $sale = new Sales();
            $sale->date_admission = Carbon::now();
            $sale->commission = $amount;
            $sale->observation = $observation;
            $sale->status = 1;
            $sale->agent_id = $agent->id;
            $sale->action_id = 2;
            $sale->user_id = $user->id;
            $sale->save();

            return response()->json([
                'title' => 'Correcto',
                'text' => 'Bono registrado correctamente',
                'status' => 'success'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'title' => 'Error',
                'text' => 'Ocurrió un error: ' . $e->getMessage(),
                'status' => 'error'
            ]);
        }
    }


    // public function saveBonus(Request $request)
    // {
    //     $title = 'Error';
    //     $mensaje = 'Error desconocido';
    //     $status = 'error';

    //     $user_id = Auth::user()->id;
    //     $user = User::where('id', $user_id)->first();
    //     $roles = $user->getRoleNames()->first();

    //     $client_id = "";
    //     if ($request->dniCustomer > 0) {
    //         $client = Customers::where('code', $request->dniCustomer)->first();
    //         $client_id = $client->id;
    //     }

    //     $codeAgt = $request->dniAgent;
    //     $amount = $request->amount;
    //     $observation = $request->observation;

    //     $agent = Agent::where('code_voiso', $codeAgt)->first();

    //     try {
    //         $bonusAgent = new BonusAgent();
    //         $bonusAgent->date_admission = Carbon::now();
    //         $bonusAgent->amount = $amount;
    //         $bonusAgent->observation = $observation;
    //         $bonusAgent->status = true;
    //         // $bonusAgent->customer_id = $client_id;
    //         if ($request->percent_id > 0) {
    //             $bonusAgent->percent_id = $request->percent_id;
    //         }
    //         if ($request->commission_id > 0) {
    //             $bonusAgent->commission_id = $request->commission_id;
    //         }
    //         if ($request->exchange_rate_id > 0) {
    //             $bonusAgent->exchange_rate_id = $request->exchange_rate_id;
    //         }
    //         $bonusAgent->agent_id = $agent->id;
    //         $bonusAgent->action_id = 1;
    //         if ($bonusAgent->save()) {

    //             $sale = new Sales();
    //             $sale->date_admission = Carbon::now();
    //             $sale->amount = $amount;
    //             $sale->observation = $observation;
    //             $sale->status = true;
    //             $sale->agent_id = $agent->id;
    //             $sale->action_id = 2;
    //             $sale->user_id = Auth::user()->id;
    //             if ($sale->save()) {
    //                 $title = "Correcto";
    //                 $mensaje = "Registrado correctamente";
    //                 $status = "success";
    //             }
    //         }
    //     } catch (Exception $e) {
    //         $title = 'Error';
    //         $mensaje = 'Ocurrió un error: '.$e->getMessage();
    //         $status = 'error';
    //     }

    //     if ($roles == 'ADMINISTRADOR') {
    //         $bonusAgent = Sales::whereIn('action_id', [1, 2, 3, 4]) // Filtra por action_id 1, 2 y 3
    //                             ->where('status', 1)
    //                             ->orderBy('created_at', 'DESC') // Ordena por fecha de admisión de forma descendente
    //                             ->with('action') // Carga la relación con actions (si está definida en el modelo)
    //                             ->get();
    //     } else {

    //         $bonusAgent = Sales::whereIn('action_id', [1, 2, 3, 4]) // Filtra por action_id 1, 2 y 3
    //                             ->where('status', 1)
    //                             ->where('agent_id', $agent->id)
    //                             ->orderBy('created_at', 'DESC') // Ordena por fecha de admisión de forma descendente
    //                             ->with('action') // Carga la relación con actions (si está definida en el modelo)
    //                             ->get();

    //     }


    //     //$bonusAgent = BonusAgent::where('status', true)->orderBy('date_admission', 'desc')->get();

    //     return response()->json(["view"=>view('bonusAgente.list.listBonusAgent', compact('bonusAgent'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    // }

    // public function saveRetiro(Request $request)
    // {
    //     $codeCustomer = $request->dniCustomer;
    //     $amount = $request->amount;
    //     $observation = $request->observation;
    //     $percentId = $request->percent_id;
    //     $commissionId = $request->comission_id;
    //     $exchangeRateId = $request->exchange_rate_id;
    //     $codeAgent = $request->dniAgent;
    //     $clientId = "";
    //     $userId = Auth::user()->id;
    //     $user = User::where('id', $userId)->first();
    //     $roles = $user->getRoleNames()->first();
    //     if ($codeCustomer > 0) {
    //         $client = Customers::where('code', $codeCustomer)->first();
    //         $clientId = $client->id;
    //     }
    //     $agent = Agent::where('code_voiso', $codeAgent)->first();
    //     try {
    //         $bonusAgent = new BonusAgent();
    //         $bonusAgent->date_admission = Carbon::now();
    //         $bonusAgent->amount = $amount;
    //         $bonusAgent->observation = $observation;
    //         $bonusAgent->status = true;

    //         if ($percentId > 0) {
    //             $bonusAgent->percent_id = $percentId;
    //         }
    //         if ($commissionId > 0) {
    //             $bonusAgent->commission_id = $commissionId;
    //         }
    //         if ($exchangeRateId > 0) {
    //             $bonusAgent->exchange_rate_id = $exchangeRateId;
    //         }
    //         $bonusAgent->agent_id = $agent->id;
    //         $bonusAgent->action_id = 4;
    //         if ($bonusAgent->save()) {
    //             $sale = new Sales();
    //             $sale->date_admission = Carbon::now();
    //             $sale->commission = $amount;
    //             $sale->observation = $observation;
    //             $sale->status = true;
    //             $sale->agent_id = $agent->id;
    //             $sale->action_id = 4;
    //             $sale->user_id = Auth::user()->id;
    //             if ($sale->save()) {
    //                 $title = "Correcto";
    //                 $mensaje = "Registrado correctamente";
    //                 $status = "success";
    //             }
    //         }
    //     } catch (Exception $e) {
    //         $title = 'Error';
    //         $mensaje = 'Ocurrió un error: '.$e->getMessage();
    //         $status = 'error';
    //     }
    //     if ($roles == 'ADMINISTRADOR') {
    //         $bonusAgent = Sales::whereIn('action_id', [1, 2, 3, 4]) // Filtra por action_id 1, 2 y 3
    //                             ->where('status', 1)
    //                             ->orderBy('created_at', 'DESC') // Ordena por fecha de admisión de forma descendente
    //                             ->with('action') // Carga la relación con actions (si está definida en el modelo)
    //                             ->get();
    //     } else {

    //         $bonusAgent = Sales::whereIn('action_id', [1, 2, 3, 4]) // Filtra por action_id 1, 2 y 3
    //                             ->where('status', 1)
    //                             ->where('agent_id', $agent->id)
    //                             ->orderBy('created_at', 'DESC') // Ordena por fecha de admisión de forma descendente
    //                             ->with('action') // Carga la relación con actions (si está definida en el modelo)
    //                             ->get();

    //     }

    //     return response()->json(["view"=>view('bonusAgente.list.listBonusAgent', compact('bonusAgent'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    // }

    public function saveRetiro(Request $request)
    {
        $codeAgent = $request->dniAgent;
        $amount = $request->amount;
        $observation = $request->observation;

        $user = Auth::user();
        $agent = Agent::where('code_voiso', $codeAgent)->first();

        if (!$agent) {
            return response()->json([
                'title' => 'Error',
                'text' => 'Agente no encontrado.',
                'status' => 'error'
            ]);
        }

        try {
            // Guardar en BonusAgent
            $bonus = new BonusAgent();
            $bonus->date_admission = Carbon::now();
            $bonus->amount = $amount;
            $bonus->observation = $observation;
            $bonus->status = 1;
            $bonus->agent_id = $agent->id;
            $bonus->action_id = 4;
            $bonus->save();

            // Guardar en Sales
            $sale = new Sales();
            $sale->date_admission = Carbon::now();
            $sale->commission = $amount;
            $sale->observation = $observation;
            $sale->status = 1;
            $sale->agent_id = $agent->id;
            $sale->action_id = 4;
            $sale->user_id = $user->id;
            $sale->save();

            return response()->json([
                'title' => 'Correcto',
                'text' => 'Descuento registrado correctamente',
                'status' => 'success'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'title' => 'Error',
                'text' => 'Ocurrió un error: ' . $e->getMessage(),
                'status' => 'error'
            ]);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
    public function filterBonus(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        $roles = $user->getRoleNames()->first();
        $agent = Agent::where('user_id', $user->id)->first();

        // Validar y convertir fechas
        $dateInit = DateTime::createFromFormat('d/m/Y', $request->dateInit)?->format('Y-m-d');
        $dateEnd = DateTime::createFromFormat('d/m/Y', $request->dateEnd)?->format('Y-m-d');

        $query = Sales::query()
            ->whereIn('action_id', [1, 2, 3, 4])
            ->where('status', 1)
            ->with(['agent.area', 'action']);

        if ($roles !== 'ADMINISTRADOR') {
            $query->where('agent_id', $agent->id);
        } else {
            if ($request->area) {
                $query->whereHas('agent', function ($q) use ($request) {
                    $q->where('area_id', $request->area);
                });
            }
            if ($request->code) {
                $query->whereHas('agent', function ($q) use ($request) {
                    $q->where('id', '=', "$request->code")
                    ->orWhere(DB::raw("CONCAT(name, ' ', lastname)"), 'LIKE', "%{$request->code}%");
                });
            }
        }

        if ($dateInit && $dateEnd) {
            $query->whereBetween('date_admission', [$dateInit, $dateEnd]);
        }

        $bonusAgent = $query->orderByDesc('created_at')->paginate(10);

        // Calcular Totales (solo para el agente logueado)
        $reportTargetMensual = Target::where('status', true)
            ->where('month', date("m"))
            ->where('agent_id', $agent->id)
            ->sum('amount');

        $amount = DB::table('sales as s')
            ->join('actions as a', 's.action_id', '=', 'a.id')
            ->join('movement_types as m', 'a.movement_type_id', '=', 'm.id')
            ->where('m.name', 'INGRESO')
            ->where('s.agent_id', $agent->id)
            ->whereBetween('s.date_admission', [$dateInit, $dateEnd])
            ->where('s.status', 1)
            ->sum('s.amount');

        $amountRetiro = DB::table('sales as s')
            ->join('actions as a', 's.action_id', '=', 'a.id')
            ->join('movement_types as m', 'a.movement_type_id', '=', 'm.id')
            ->where('m.name', 'EGRESO')
            ->where('s.agent_id', $agent->id)
            ->whereBetween('s.date_admission', [$dateInit, $dateEnd])
            ->where('s.status', 1)
            ->sum('s.amount');

        $cuotaPendiente = $reportTargetMensual - $amount;

        return response()->json([
            'viewTable' => view('bonusAgente.partials._tabBonus', compact('bonusAgent'))->render(),
            'viewTotals' => view('bonusAgente.partials._tabTotalTarget', compact('reportTargetMensual', 'amount', 'amountRetiro', 'cuotaPendiente'))->render(),
        ]);
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
