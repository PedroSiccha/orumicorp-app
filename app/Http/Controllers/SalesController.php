<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Models\Agent;
use App\Models\Area;
use App\Models\Commission;
use App\Models\Customers;
use App\Models\ExchangeRate;
use App\Models\Percent;
use App\Models\Premio;
use App\Models\Sales;
use App\Models\User;
use App\Services\SalesService;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\isNull;

class SalesController extends Controller
{

    protected $saleService;

    public function __construct(SalesService $saleService) {
        $this->saleService = $saleService;
    }

    public function index()
    {
        return view('venta.index', compact('percents', 'commissions', 'exchange_rates', 'sales', 'premios1', 'premios2', 'dataUser', 'rouletteSpin', 'totalAmount', 'areas'));
        try {
            $data = $this->saleService->getSaleData();
            $percents = $data->percents;
            $commissions = $data->commissions;
            $exchange_rates = $data->exchange_rates;
            $sales = $data->sales;
            $rouletteSpin = $data->rouletteSpin;
            $totalAmount = $sales->sum('amount');
            $areas = $data->areas;
            return view('venta.index', compact('percents', 'commissions', 'exchange_rates', 'sales', 'premios1', 'premios2', 'dataUser', 'rouletteSpin', 'totalAmount', 'areas'));
        } catch (Exception $e) {
            Log::error("Error en SalesController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar las ventas.');
        }
    }

    public function searchCustomer(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $name = "";

        try {

            $client = Customers::where('code', $request->dni)->orWhere('id', $request->dni)->first();

            if (is_null($client)) {
                $mensaje = "El cliente no existe";
            } else {
                $title = "Éxito";
                $status = "success";
                $name = $client->name . " " . $client->lastname;
                $mensaje = "Cliente encontrado exitosamente";
            }

        } catch (Exception $e) {
            $mensaje = "Error " . $e->getMessage();
        }

        return response()->json(["name" => $name, "title" => $title, "text" => $mensaje, "status" => $status]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveSale(SaleRequest $request)
    {
        try {
            $data = $this->saleService->saveSale($request);
            $bonusAgent = $data->bonusAgent;
            return response()->json(["view"=>view('bonusAgente.list.listBonusAgent', compact('bonusAgent'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
        } catch (Exception $e) {
            Log::error("Error en SalesController: " . $e->getMessage());
        }
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";
        // $client_id = null;
        // $commission = 0;
        // $amount = 0;

        // if ($request->dniCustomer != null) {
        //     $client = Customers::where('id', $request->dniCustomer)
        //           ->orWhere('code', $request->dniCustomer)
        //           ->first();

        //     $client_id = $client->id;
        // }

        // $agent = Agent::where('code_voiso', $request->dniAgent)
        //          ->orWhere('code', $request->dniAgent)
        //          ->first();

        // if ($agent == null) {
        //     $title = "Error";
        //     $mensaje = "Hubo un error con el agente";
        //     $status = "error";
        // }

        // if ($request->typeSales == 3) {
        //     $commission = (-1)*$request->commission;
        // } else {
        //     $commission = $request->commission;
        // }

        // if ($request->amount) {
        //     $amount = $request->amount;
        // } else {
        //     $amount = $commission;
        // }


        // try {
        //     $sale = new Sales();
        //     $sale->date_admission = Carbon::now();
        //     $sale->amount = $amount;
        //     $sale->observation = $request->observation;
        //     $sale->status = true;
        //     $sale->customer_id = $client_id;
        //     $sale->percent = $request->percent;
        //     $sale->commission = $commission;
        //     $sale->exchange_rate = $request->exchange_rate;
        //     $sale->agent_id = $agent->id;
        //     $sale->action_id = $request->typeSales;
        //     $sale->user_id = Auth::user()->id;
        //     if ($sale->save()) {
        //         $title = "Correcto";
        //         $mensaje = "La venta se registró correctamente";
        //         $status = "success";
        //     } else {
        //         $title = "Error";
        //         $mensaje = "Hubo un error al guardar la venta";
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

    public function filterSales(Request $request)
    {
        try {
            $data = $this->saleService->filterSales($request);
            $sales = $data->sales;
            $totalAmount = $data->totalAmount;
            return response()->json(["view"=>view('venta.list.listSale', compact('sales', 'totalAmount'))->render()]);
        } catch (Exception $e) {
            Log::error("Error en SalesController: " . $e->getMessage());
        }
    }

    public function obtenerDatosVentas()
    {
        try {
            $data = $this->saleService->getSaleData();
            $lineData = $this->getLineData($data);
        } catch (Exception $e) {
            Log::error("Error en SalesController: " . $e->getMessage());
        }
        // $year = now()->year;
        // $totalVentas = DB::table(DB::raw('(SELECT 1 AS mes UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12) meses'))
        //     ->crossJoin('areas')
        //     ->leftJoin(DB::raw('(SELECT MONTH(date_admission) AS mes, agents.area_id, SUM(amount) AS amount FROM sales INNER JOIN agents ON sales.agent_id = agents.id WHERE YEAR(date_admission) = '.$year.' GROUP BY mes, agents.area_id) sales'), function ($join) {
        //         $join->on('meses.mes', '=', 'sales.mes')->on('areas.id', '=', 'sales.area_id');
        //     })
        //     ->select(
        //         'meses.mes as mes',
        //         'areas.name as area',
        //         DB::raw('COALESCE(SUM(sales.amount), 0) AS total_ventas')
        //     )
        //     ->groupBy('meses.mes', 'areas.name')
        //     ->orderBy('meses.mes', 'asc')
        //     ->orderBy('areas.name', 'asc')
        //     ->get();

        // $lineData = [
        //     'labels' => ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        //     'datasets' => []
        // ];

        // $areas = $totalVentas->pluck('area')->unique()->toArray();

        // foreach ($areas as $area) {
        //     $ventasPorArea = $totalVentas->where('area', $area)->pluck('total_ventas')->toArray();
        //     $color = $this->randomColor();
        //     $lineData['datasets'][] = [
        //         'label' => $area,
        //         'backgroundColor' => $color,
        //         'borderColor' => $color,
        //         'pointBackgroundColor' => $color,
        //         'pointBorderColor' => '#fff',
        //         'data' => $ventasPorArea
        //     ];
        // }

        // return response()->json($lineData);
    }

    private function randomColor()
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSale(SaleRequest $request)
    {
        try {
            $data = $this->saleService->updateSale($request);
            $bonusAgent = $data->bonusAgent;
            return response()->json(["view"=>view('bonusAgente.list.listBonusAgent', compact('bonusAgent'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
        } catch (Exception $e) {
            Log::error("Error en SalesController: " . $e->getMessage());
        }
    }

}
