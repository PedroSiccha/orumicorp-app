<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Area;
use App\Models\Customers;
use App\Models\Premio;
use App\Models\Sales;
use App\Models\User;
use App\Services\StatisticsService;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StatisticsTodayController extends Controller
{

    protected $statisticsTodayService;

    public function __construct(StatisticsService $statisticsTodayService) {
        $this->statisticsTodayService = $statisticsTodayService;
    }
    
    public function index()
    {
        try {
            $data = $this->statisticsTodayService->getStatisticsTodayData();
            $sales = $data->sales;
            $areas = $data->areas;
            $rouletteSpin = $data->rouletteSpin;
            return view('todayStatistics.index', compact('sales', 'premios1', 'premios2', 'dataUser', 'areas', 'rouletteSpin'));
        } catch (Exception $e) {
            Log::error("Error en StatisticsTodayController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar las estadísticas.');
        }
<<<<<<< HEAD

        if ($client) {
            $dataUser = $client;
        }

        $currentDate = Carbon::now()->toDateString();
        $currentMonth = Carbon::now()->format('Y-m');

        if ($roles == 'ADMINISTRADOR') {
            $sales = Sales::join('agents as a', 'sales.agent_id', '=', 'a.id')
                            ->selectRaw('
                                a.name, 
                                a.lastname,
                                SUM(CASE WHEN sales.action_id = 1 THEN sales.amount ELSE 0 END) AS total_amount_action_4,
                                SUM(CASE WHEN sales.action_id = 1 AND DATE(sales.created_at) = ? THEN sales.amount ELSE 0 END) AS total_amount_day,
                                SUM(CASE WHEN sales.action_id = 1 AND DATE_FORMAT(sales.created_at, "%Y-%m") = ? THEN sales.amount ELSE 0 END) AS total_amount_month
                            ')
                            ->addSelect(DB::raw('
                                (SELECT COUNT(*) FROM sales 
                                WHERE sales.action_id = 1 
                                AND DATE(sales.created_at) = ? 
                                AND sales.agent_id = a.id) AS total_sales_day
                            '))
                            ->addSelect(DB::raw('
                                (SELECT COUNT(*) FROM sales 
                                WHERE sales.action_id = 1 
                                AND DATE_FORMAT(sales.created_at, "%Y-%m") = ? 
                                AND sales.agent_id = a.id) AS total_sales_month
                            '))
                            ->groupBy('a.id')
                            ->orderBy('total_amount_day', 'DESC')
                            ->setBindings([$currentDate, $currentMonth, $currentDate, $currentMonth])
                            ->get();


        } else {

            $sales = Sales::join('agents as a', 'sales.agent_id', '=', 'a.id')
                            ->selectRaw('
                                a.name, 
                                a.lastname,
                                SUM(CASE WHEN sales.action_id = 1 THEN sales.amount ELSE 0 END) AS total_amount_action_4,
                                SUM(CASE WHEN sales.action_id = 1 AND DATE(sales.created_at) = ? THEN sales.amount ELSE 0 END) AS total_amount_day,
                                SUM(CASE WHEN sales.action_id = 1 AND DATE_FORMAT(sales.created_at, "%Y-%m") = ? THEN sales.amount ELSE 0 END) AS total_amount_month
                            ')
                            ->addSelect(DB::raw('
                                (SELECT COUNT(*) FROM sales 
                                WHERE sales.action_id = 1 
                                AND DATE(sales.created_at) = ? 
                                AND sales.agent_id = a.id) AS total_sales_day
                            '))
                            ->addSelect(DB::raw('
                                (SELECT COUNT(*) FROM sales 
                                WHERE sales.action_id = 1 
                                AND DATE_FORMAT(sales.created_at, "%Y-%m") = ? 
                                AND sales.agent_id = a.id) AS total_sales_month
                            '))
                            ->where('sales.agent_id', $agent->id)
                            ->groupBy('a.id')
                            ->orderBy('total_amount_day', 'DESC')
                            ->setBindings([$currentDate, $currentMonth, $currentDate, $currentMonth])
                            ->get();

        }


        $areas = Area::where('status', 1)->get();
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();

        return view('todayStatistics.index', compact('sales', 'premios1', 'premios2', 'dataUser', 'areas', 'rouletteSpin'));
=======
>>>>>>> feature/fix-presentation
    }

    public function filterStatistics(Request $request)
    {
<<<<<<< HEAD
        $user = User::where('id', Auth::user()->id)->first();
        $roles = $user->getRoleNames()->first();

        $dateInit = DateTime::createFromFormat('d/m/Y', $request->dateInit)->format('Y-m-d');
        $dateEnd = DateTime::createFromFormat('d/m/Y', $request->dateEnd)->format('Y-m-d');

        $currentDate = Carbon::now()->toDateString();
        $currentMonth = Carbon::now()->format('Y-m');

        $agent = Agent::where('area_id', $request->area)->first();

        if ($roles == 'ADMINISTRADOR') {
            $sales = Sales::join('agents as a', 'sales.agent_id', '=', 'a.id')
                ->selectRaw('
                    a.name, 
                    a.lastname,
                    SUM(CASE WHEN sales.action_id = 1 THEN sales.amount ELSE 0 END) AS total_amount_action_4,
                    SUM(CASE WHEN sales.action_id = 1 AND DATE(sales.created_at) = ? THEN sales.amount ELSE 0 END) AS total_amount_day,
                    SUM(CASE WHEN sales.action_id = 1 AND DATE_FORMAT(sales.created_at, "%Y-%m") = ? THEN sales.amount ELSE 0 END) AS total_amount_month,
                    (SELECT COUNT(*) FROM sales 
                     WHERE sales.action_id = 1 
                       AND DATE(sales.created_at) = ? 
                       AND sales.agent_id = a.id) AS total_sales_day,
                    (SELECT COUNT(*) FROM sales 
                     WHERE sales.action_id = 1 
                       AND DATE_FORMAT(sales.created_at, "%Y-%m") = ? 
                       AND sales.agent_id = a.id) AS total_sales_month
                ', [
                    $currentDate,   // para total_amount_day
                    $currentMonth,  // para total_amount_month
                    $currentDate,   // para total_sales_day
                    $currentMonth   // para total_sales_month
                ])
                ->where('a.area_id', $request->area)
                ->whereBetween('sales.date_admission', [$dateInit, $dateEnd])
                ->groupBy('a.id')
                ->orderBy('total_amount_day', 'DESC')
                ->get();
        } else {
            $sales = Sales::join('agents as a', 'sales.agent_id', '=', 'a.id')
                ->selectRaw('
                    a.name, 
                    a.lastname,
                    SUM(CASE WHEN sales.action_id = 1 THEN sales.amount ELSE 0 END) AS total_amount_action_4,
                    SUM(CASE WHEN sales.action_id = 1 AND DATE(sales.created_at) = ? THEN sales.amount ELSE 0 END) AS total_amount_day,
                    SUM(CASE WHEN sales.action_id = 1 AND DATE_FORMAT(sales.created_at, "%Y-%m") = ? THEN sales.amount ELSE 0 END) AS total_amount_month,
                    (SELECT COUNT(*) FROM sales 
                     WHERE sales.action_id = 1 
                       AND DATE(sales.created_at) = ? 
                       AND sales.agent_id = a.id) AS total_sales_day,
                    (SELECT COUNT(*) FROM sales 
                     WHERE sales.action_id = 1 
                       AND DATE_FORMAT(sales.created_at, "%Y-%m") = ? 
                       AND sales.agent_id = a.id) AS total_sales_month
                ', [
                    $currentDate,
                    $currentMonth,
                    $currentDate,
                    $currentMonth
                ])
                ->where('a.area_id', $request->area)
                ->where('sales.agent_id', $agent->id)
                ->whereBetween('sales.date_admission', [$dateInit, $dateEnd])
                ->groupBy('a.id')
                ->orderBy('total_amount_day', 'DESC')
                ->get();
        }
        
        


        // $sales = Sales::join('agents as a', 'sales.agent_id', '=', 'a.id')
        //                     ->selectRaw('a.name, a.lastname,
        //                                 SUM(CASE WHEN sales.action_id = 4 THEN sales.amount ELSE 0 END) AS total_amount_action_4,
        //                                 SUM(sales.amount) AS total_amount_day,
        //                                 SUM(sales.amount) AS total_amount_month')
        //                     ->addSelect(DB::raw('(SELECT COUNT(*) FROM sales WHERE sales.agent_id = a.id) AS total_sales_day'))
        //                     ->addSelect(DB::raw('(SELECT COUNT(*) FROM sales WHERE sales.agent_id = a.id) AS total_sales_month'))
        //                     ->where('a.area_id', $request->area)
        //                     ->whereBetween('sales.date_admission', [$dateInit, $dateEnd])
        //                     ->groupBy('a.id')
        //                     ->orderBy('total_amount_day', 'DESC')
        //                     ->get();

        return response()->json(["view"=>view('todayStatistics.components.tabStatistics', compact('sales'))->render()]);
=======
        try {
            $data = $this->statisticsTodayService->filterStatistics($request);
            $sales = $data->sales;
            return response()->json(["view"=>view('todayStatistics.components.tabStatistics', compact('sales'))->render()]);
        } catch (Exception $e) {
            Log::error("Error en StatisticsTodayController: " . $e->getMessage());
        }
>>>>>>> feature/fix-presentation
    }

}
