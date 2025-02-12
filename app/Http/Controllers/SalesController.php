<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Area;
use App\Models\Commission;
use App\Models\Customers;
use App\Models\ExchangeRate;
use App\Models\Percent;
use App\Models\Premio;
use App\Models\Sales;
use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class SalesController extends Controller
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

        $percents = Percent::where('status', true)->get();
        $commissions = Commission::where('status', true)->get();
        $exchange_rates = ExchangeRate::where('status', true)->get();
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
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $areas = Area::where('status', true)->get();
        return view('venta.index', compact('percents', 'commissions', 'exchange_rates', 'sales', 'premios1', 'premios2', 'dataUser', 'rouletteSpin', 'totalAmount', 'areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function saveSale(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $client_id = null;
        $commission = 0;
        $amount = 0;

        if ($request->dniCustomer != null) {
            $client = Customers::where('id', $request->dniCustomer)
                  ->orWhere('code', $request->dniCustomer)
                  ->first();

            $client_id = $client->id;
        }

        $agent = Agent::where('code_voiso', $request->dniAgent)
                 ->orWhere('code', $request->dniAgent)
                 ->first();

        if ($agent == null) {
            $title = "Error";
            $mensaje = "Hubo un error con el agente";
            $status = "error";
        }

        if ($request->typeSales == 3) {
            $commission = (-1)*$request->commission;
        } else {
            $commission = $request->commission;
        }

        if ($request->amount) {
            $amount = $request->amount;
        } else {
            $amount = $commission;
        }


        try {
            $sale = new Sales();
            $sale->date_admission = Carbon::now();
            $sale->amount = $amount;
            $sale->observation = $request->observation;
            $sale->status = true;
            $sale->customer_id = $client_id;
            $sale->percent = $request->percent;
            $sale->commission = $commission;
            $sale->exchange_rate = $request->exchange_rate;
            $sale->agent_id = $agent->id;
            $sale->action_id = $request->typeSales;
            $sale->user_id = Auth::user()->id;
            if ($sale->save()) {
                $title = "Correcto";
                $mensaje = "La venta se registró correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "Hubo un error al guardar la venta";
                $status = "error";
            }

        } catch (Exception $e) {
            $title = "Error";
            $mensaje = "Error: ".$e;
            $status = "error";
        }

        switch ($request->typeSales) {
            case 1:

                $currentMonth = Carbon::now()->month;
                $currentYear = Carbon::now()->year;

                $previousMonth = Carbon::now()->subMonth()->month;
                $previousYear = Carbon::now()->subMonth()->year;

                $sales = Sales::where('status', true)
                                ->where('action_id', $request->typeSales)
                                ->where(function ($query) use ($currentMonth, $currentYear, $previousMonth, $previousYear) {
                                    $query->whereYear('date_admission', $currentYear)->whereMonth('date_admission', $currentMonth)
                                            ->orWhere(function ($query) use ($previousMonth, $previousYear) {
                                                $query->whereYear('date_admission', $previousYear)->whereMonth('date_admission', $previousMonth);
                                            });
                                })
                                ->orderBy('date_admission', 'desc')
                                ->get();
                $totalAmount = $sales->sum('amount');

                return response()->json(["view"=>view('venta.list.listSale', compact('sales', 'totalAmount'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
                break;
            case 2:
                $bonusAgent = Sales::where('status', true)
                                    ->where('action_id', 2)
                                    ->orWhere('action_id', 3)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

                return response()->json(["view"=>view('bonusAgente.list.listBonusAgent', compact('bonusAgent'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
                break;
            case 3:
                $bonusAgent = Sales::where('status', true)
                            ->where('action_id', 2)
                            ->orWhere('action_id', 3)
                            ->orderBy('created_at', 'desc')
                            ->get();

                return response()->json(["view"=>view('bonusAgente.list.listBonusAgent', compact('bonusAgent'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
                break;
            default:
                echo "Opción no válida";
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function filterSales(Request $request)
    {
        $dateInit = DateTime::createFromFormat('m/d/Y', $request->dateInit)->format('Y-m-d');
        $dateEnd = DateTime::createFromFormat('m/d/Y', $request->dateEnd)->format('Y-m-d');
        $codigo = $request->code;
        $nombre = $request->code;

        $sales = Sales::join('agents as a', 'sales.agent_id', '=', 'a.id')
                        ->where('sales.action_id', 1)
                        ->where(function ($query) use ($codigo, $nombre) {
                            $query->where('a.code', 'LIKE', '%' . $codigo . '%')
                                ->orWhere(DB::raw("CONCAT(a.name, ' ', a.lastname)"), 'LIKE', '%' . $nombre . '%');
                        })
                        ->where('a.area_id', $request->area)
                        ->whereBetween('sales.date_admission', [$dateInit, $dateEnd])
                        ->get();

        $totalAmount = $sales->sum('amount');

        return response()->json(["view"=>view('venta.list.listSale', compact('sales', 'totalAmount'))->render()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function obtenerDatosVentas()
    {
        $year = now()->year;
        $totalVentas = DB::table(DB::raw('(SELECT 1 AS mes UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12) meses'))
            ->crossJoin('areas')
            ->leftJoin(DB::raw('(SELECT MONTH(date_admission) AS mes, agents.area_id, SUM(amount) AS amount FROM sales INNER JOIN agents ON sales.agent_id = agents.id WHERE YEAR(date_admission) = '.$year.' GROUP BY mes, agents.area_id) sales'), function ($join) {
                $join->on('meses.mes', '=', 'sales.mes')->on('areas.id', '=', 'sales.area_id');
            })
            ->select(
                'meses.mes as mes',
                'areas.name as area',
                DB::raw('COALESCE(SUM(sales.amount), 0) AS total_ventas')
            )
            ->groupBy('meses.mes', 'areas.name')
            ->orderBy('meses.mes', 'asc')
            ->orderBy('areas.name', 'asc')
            ->get();

        $lineData = [
            'labels' => ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            'datasets' => []
        ];

        $areas = $totalVentas->pluck('area')->unique()->toArray();

        foreach ($areas as $area) {
            $ventasPorArea = $totalVentas->where('area', $area)->pluck('total_ventas')->toArray();
            $color = $this->randomColor();
            $lineData['datasets'][] = [
                'label' => $area,
                'backgroundColor' => $color,
                'borderColor' => $color,
                'pointBackgroundColor' => $color,
                'pointBorderColor' => '#fff',
                'data' => $ventasPorArea
            ];
        }

        return response()->json($lineData);
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
    public function updateSale(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $commission = 0;
        $amount = 0;

        $agent = Agent::where('dni', $request->eCodAgent)
                 ->orWhere('code', $request->eCodAgent)
                 ->first();

        if ($request->typeSales == 3) {
            $commission = (-1)*$request->eComission;
        } else {
            $commission = $request->eComission;
        }

        if ($request->eAmount) {
            $amount = $request->eAmount;
        } else {
            $amount = $commission;
        }


        try {
            $sale = Sales::where('id', $request->eId)->first();
            $sale->amount = $amount;
            $sale->observation = $request->eObservation;
            $sale->status = true;
            $sale->percent = $request->ePercent;
            $sale->commission = $commission;
            $sale->exchange_rate = $request->eTypeChange;
            $sale->action_id = $request->typeSales;
            $sale->agent_id = $agent->id;
            $sale->user_id = Auth::user()->id;
            if ($sale->save()) {
                $title = "Correcto";
                $mensaje = "La venta se actualizó correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "Hubo un error al actualizar la venta";
                $status = "error";
            }

        } catch (Exception $e) {
            $title = "Error";
            $mensaje = "Error: ".$e;
            $status = "error";
        }

        switch ($request->typeSales) {
            case 1:

                $currentMonth = Carbon::now()->month;
                $currentYear = Carbon::now()->year;

                $previousMonth = Carbon::now()->subMonth()->month;
                $previousYear = Carbon::now()->subMonth()->year;

                $sales = Sales::where('status', true)
                                ->where('action_id', $request->typeSales)
                                ->where(function ($query) use ($currentMonth, $currentYear, $previousMonth, $previousYear) {
                                    $query->whereYear('date_admission', $currentYear)->whereMonth('date_admission', $currentMonth)
                                            ->orWhere(function ($query) use ($previousMonth, $previousYear) {
                                                $query->whereYear('date_admission', $previousYear)->whereMonth('date_admission', $previousMonth);
                                            });
                                })
                                ->orderBy('date_admission', 'desc')
                                ->get();
                $totalAmount = $sales->sum('amount');

                return response()->json(["view"=>view('venta.list.listSale', compact('sales', 'totalAmount'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
                break;
            case 2:
                $bonusAgent = Sales::where('status', true)
                                    ->where('action_id', 2)
                                    ->orWhere('action_id', 3)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

                return response()->json(["view"=>view('bonusAgente.list.listBonusAgent', compact('bonusAgent'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
                break;
            case 3:
                $bonusAgent = Sales::where('status', true)
                            ->where('action_id', 2)
                            ->orWhere('action_id', 3)
                            ->orderBy('created_at', 'desc')
                            ->get();

                return response()->json(["view"=>view('bonusAgente.list.listBonusAgent', compact('bonusAgent'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
                break;
            default:
                echo "Opción no válida";
        }
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
