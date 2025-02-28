<?php
namespace App\Services;

use App\Http\Requests\SaleRequest;
use Illuminate\Http\Request;

class SalesService
{

    protected $salesRepository;

    public function __construct(
        SalesRepositoryInterface $salesRepository
    ) {
        $this->salesRepository = $salesRepository;
    }

    public function saveSale(SaleRequest $request)
    {
        // $user_id = Auth::user()->id;
        // $agent = Agent::where('user_id', $user_id)->first();
        // $premio = Premio::where('order', $request->premio)->first();

        // $sale = new Sales();
        // $sale->date_admission = Carbon::now();
        // $sale->status = true;
        // $sale->observation = "Giro de Ruleta";
        // $sale->commission = $premio->value;
        // $sale->agent_id = $agent->id;
        // $sale->action_id = '2';
        // $sale->user_id = $user_id;
        // $sale->save();
    }

    public function getSaleData()
    {
        // $user_id = Auth::user()->id;
        // $user = User::where('id', $user_id)->first();
        // $roles = $user->getRoleNames()->first();

        // $agent = Agent::where('user_id', $user_id)->first();
        // $client = Customers::where('user_id', $user_id)->first();
        // $rouletteSpin = $agent->number_turns ?: 0;

        // $currentMonth = Carbon::now()->month;
        // $currentYear = Carbon::now()->year;

        // $previousMonth = Carbon::now()->subMonth()->month;
        // $previousYear = Carbon::now()->subMonth()->year;

        // $dataUser = null;

        // if ($agent) {
        //     $dataUser = $agent;
        // }

        // if ($client) {
        //     $dataUser = $client;
        // }

        // $percents = Percent::where('status', true)->get();
        // $commissions = Commission::where('status', true)->get();
        // $exchange_rates = ExchangeRate::where('status', true)->get();
        // if ($roles == 'ADMINISTRADOR') {
        //     $sales = Sales::where('status', true)
        //     ->where('action_id', 1)
        //     ->where(function ($query) use ($currentMonth, $currentYear, $previousMonth, $previousYear) {
        //         $query->whereYear('date_admission', $currentYear)->whereMonth('date_admission', $currentMonth)
        //                 ->orWhere(function ($query) use ($previousMonth, $previousYear) {
        //                     $query->whereYear('date_admission', $previousYear)->whereMonth('date_admission', $previousMonth);
        //                 });
        //     })
        //     ->orderBy('date_admission', 'desc')
        //     ->get();
        // } else {
        //     $sales = Sales::where('status', true)
        //     ->where('action_id', 1)
        //     ->where('agent_id', $agent->id)
        //     ->where(function ($query) use ($currentMonth, $currentYear, $previousMonth, $previousYear) {
        //         $query->whereYear('date_admission', $currentYear)->whereMonth('date_admission', $currentMonth)
        //                 ->orWhere(function ($query) use ($previousMonth, $previousYear) {
        //                     $query->whereYear('date_admission', $previousYear)->whereMonth('date_admission', $previousMonth);
        //                 });
        //     })
        //     ->orderBy('date_admission', 'desc')
        //     ->get();
        // }

        // $totalAmount = $sales->sum('amount');
        // $premios1 = Premio::where('status', true)->where('type', 1)->get();
        // $premios2 = Premio::where('status', true)->where('type', 2)->get();
        // $areas = Area::where('status', true)->get();
        // return view('venta.index', compact('percents', 'commissions', 'exchange_rates', 'sales', 'premios1', 'premios2', 'dataUser', 'rouletteSpin', 'totalAmount', 'areas'));
    }

    public function filterSales(Request $request)
    {
        // try {
        //     if (preg_match('/\d{2}\/\d{2}\/\d{4}/', $request->dateInit)) {
        //         $dateParts = explode('/', $request->dateInit);
        //         if ((int)$dateParts[0] > 12) {
        //             $dateInit = Carbon::createFromFormat('d/m/Y', $request->dateInit)->startOfDay();
        //         } else {
        //             $dateInit = Carbon::createFromFormat('m/d/Y', $request->dateInit)->startOfDay();
        //         }
        //     } else {
        //         throw new \Exception("Formato de fecha inválido en dateInit.");
        //     }
    
        //     if (preg_match('/\d{2}\/\d{2}\/\d{4}/', $request->dateEnd)) {
        //         $dateParts = explode('/', $request->dateEnd);
        //         if ((int)$dateParts[0] > 12) {
        //             $dateEnd = Carbon::createFromFormat('d/m/Y', $request->dateEnd)->endOfDay();
        //         } else {
        //             $dateEnd = Carbon::createFromFormat('m/d/Y', $request->dateEnd)->endOfDay();
        //         }
        //     } else {
        //         throw new \Exception("Formato de fecha inválido en dateEnd.");
        //     }
    
        // } catch (\Exception $e) {
        //     \Log::error('Error en conversión de fechas: ' . $e->getMessage());
        //     return response()->json(['error' => 'Formato de fecha inválido'], 400);
        // }
    
        // $codigo = $request->code;
        // $areaId = $request->area;
    
        // \Log::info([
        //     'Filtrando Ventas desde' => $dateInit->toDateTimeString(),
        //     'Hasta' => $dateEnd->toDateTimeString(),
        //     'Fecha desde Request' => $request->dateInit,
        //     'Fecha hasta Request' => $request->dateEnd
        // ]);

        // $sales = Sales::whereHas('agent', function ($query) use ($codigo, $areaId) {
        //             if (!empty($areaId)) {
        //                 $query->where('area_id', $areaId);
        //             }
        //             if (!empty($codigo)) {
        //                 $query->where(function ($q) use ($codigo) {
        //                     $q->where('code_voiso', $codigo)
        //                         ->orWhere('name', 'LIKE', "%$codigo%")
        //                         ->orWhere('lastname', 'LIKE', "%$codigo%");
        //                 });
        //             }
        //         })
        //         ->whereDate('date_admission', '>=', $dateInit->toDateTimeString())
        //         ->whereDate('date_admission', '<=', $dateEnd->toDateTimeString())
        //         ->with(['agent', 'customer']) // Evitar N+1 queries
        //         ->get();

        // $totalAmount = $sales->sum('amount');

        // return response()->json(["view"=>view('venta.list.listSale', compact('sales', 'totalAmount'))->render()]);
    }

    public function updateSale(SaleRequest $request)
    {
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";
        // $commission = 0;
        // $amount = 0;

        // $agent = Agent::where('code_voiso', $request->eCodAgent)
        //          ->first();

        // if ($request->typeSales == 3) {
        //     $commission = (-1)*$request->eComission;
        // } else {
        //     $commission = $request->eComission;
        // }

        // if ($request->eAmount) {
        //     $amount = $request->eAmount;
        // } else {
        //     $amount = $commission;
        // }


        // try {
        //     $sale = Sales::where('id', $request->eId)->first();
        //     $sale->amount = $amount;
        //     $sale->observation = $request->eObservation;
        //     $sale->status = true;
        //     $sale->percent = $request->ePercent;
        //     $sale->commission = $commission;
        //     $sale->exchange_rate = $request->eTypeChange;
        //     $sale->action_id = $request->typeSales;
        //     $sale->agent_id = $agent->id;
        //     $sale->user_id = Auth::user()->id;
        //     if ($sale->save()) {
        //         $title = "Correcto";
        //         $mensaje = "La venta se actualizó correctamente";
        //         $status = "success";
        //     } else {
        //         $title = "Error";
        //         $mensaje = "Hubo un error al actualizar la venta";
        //         $status = "error";
        //     }

        // } catch (Exception $e) {
        //     $title = "Error";
        //     $mensaje = "Error: ".$e;
        //     $status = "error";
        // }

        // switch ($request->typeSales) {
        //     case 1:

        //         $currentMonth = Carbon::now()->month;
        //         $currentYear = Carbon::now()->year;

        //         $previousMonth = Carbon::now()->subMonth()->month;
        //         $previousYear = Carbon::now()->subMonth()->year;

        //         $sales = Sales::where('status', true)
        //                         ->where('action_id', $request->typeSales)
        //                         ->where(function ($query) use ($currentMonth, $currentYear, $previousMonth, $previousYear) {
        //                             $query->whereYear('date_admission', $currentYear)->whereMonth('date_admission', $currentMonth)
        //                                     ->orWhere(function ($query) use ($previousMonth, $previousYear) {
        //                                         $query->whereYear('date_admission', $previousYear)->whereMonth('date_admission', $previousMonth);
        //                                     });
        //                         })
        //                         ->orderBy('date_admission', 'desc')
        //                         ->get();
        //         $totalAmount = $sales->sum('amount');

        //         return response()->json(["view"=>view('venta.list.listSale', compact('sales', 'totalAmount'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
        //         break;
        //     case 2:
        //         $bonusAgent = Sales::where('status', true)
        //                             ->where('action_id', 2)
        //                             ->orWhere('action_id', 3)
        //                             ->orderBy('created_at', 'desc')
        //                             ->get();

        //         return response()->json(["view"=>view('bonusAgente.list.listBonusAgent', compact('bonusAgent'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
        //         break;
        //     case 3:
        //         $bonusAgent = Sales::where('status', true)
        //                     ->where('action_id', 2)
        //                     ->orWhere('action_id', 3)
        //                     ->orderBy('created_at', 'desc')
        //                     ->get();

        //         return response()->json(["view"=>view('bonusAgente.list.listBonusAgent', compact('bonusAgent'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
        //         break;
        //     default:
        //         echo "Opción no válida";
        // }
    }
}