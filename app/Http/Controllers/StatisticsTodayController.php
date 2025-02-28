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
    }

    public function filterStatistics(Request $request)
    {
        try {
            $data = $this->statisticsTodayService->filterStatistics($request);
            $sales = $data->sales;
            return response()->json(["view"=>view('todayStatistics.components.tabStatistics', compact('sales'))->render()]);
        } catch (Exception $e) {
            Log::error("Error en StatisticsTodayController: " . $e->getMessage());
        }
    }

}
