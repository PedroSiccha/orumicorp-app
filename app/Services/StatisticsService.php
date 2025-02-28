<?php
namespace App\Services;

use Illuminate\Http\Request;

class StatisticsService
{

    protected $statysticsrepository;

    public function __construct(
        StatysticsRepositoryInterface $statysticsrepository
    ) {
      $this->statysticsrepository = $statysticsrepository;  
    }

    public function getStatisticsTodayData()
    {
        // $user_id = Auth::user()->id;
        // $user = User::where('id', $user_id)->first();
        // $roles = $user->getRoleNames()->first();

        // $agent = Agent::where('user_id', $user_id)->first();
        // $client = Customers::where('user_id', $user_id)->first();
        // $rouletteSpin = $agent->number_turns ?: 0;

        // $dataUser = null;

        // if ($agent) {
        //     $dataUser = $agent;
        // }

        // if ($client) {
        //     $dataUser = $client;
        // }

        // $currentDate = Carbon::now()->toDateString();
        // $currentMonth = Carbon::now()->format('Y-m');

        // if ($roles == 'ADMINISTRADOR') {
        //     $sales = Sales::join('agents as a', 'sales.agent_id', '=', 'a.id')
        //                     ->selectRaw('a.name, a.lastname,
        //                                 SUM(CASE WHEN sales.action_id = 4 THEN sales.amount ELSE 0 END) AS total_amount_action_4,
        //                                 SUM(CASE WHEN DATE(sales.created_at) = ? THEN sales.amount ELSE 0 END) AS total_amount_day,
        //                                 SUM(CASE WHEN DATE_FORMAT(sales.created_at, "%Y-%m") = ? THEN sales.amount ELSE 0 END) AS total_amount_month')
        //                     ->addSelect(DB::raw('(SELECT COUNT(*) FROM sales WHERE DATE(sales.created_at) = ? AND sales.agent_id = a.id) AS total_sales_day'))
        //                     ->addSelect(DB::raw('(SELECT COUNT(*) FROM sales WHERE DATE_FORMAT(sales.created_at, "%Y-%m") = ? AND sales.agent_id = a.id) AS total_sales_month'))
        //                     ->groupBy('a.id')
        //                     ->orderBy('total_amount_day', 'DESC')
        //                     ->setBindings([$currentDate, $currentMonth, $currentDate, $currentMonth])
        //                     ->get();
        // } else {

        //     $sales = Sales::join('agents as a', 'sales.agent_id', '=', 'a.id')
        //                     ->selectRaw('a.name, a.lastname,
        //                                 SUM(CASE WHEN sales.action_id = 4 THEN sales.amount ELSE 0 END) AS total_amount_action_4,
        //                                 SUM(CASE WHEN DATE(sales.created_at) = ? THEN sales.amount ELSE 0 END) AS total_amount_day,
        //                                 SUM(CASE WHEN DATE_FORMAT(sales.created_at, "%Y-%m") = ? THEN sales.amount ELSE 0 END) AS total_amount_month')
        //                     ->addSelect(DB::raw('(SELECT COUNT(*) FROM sales WHERE DATE(sales.created_at) = ? AND sales.agent_id = a.id) AS total_sales_day'))
        //                     ->addSelect(DB::raw('(SELECT COUNT(*) FROM sales WHERE DATE_FORMAT(sales.created_at, "%Y-%m") = ? AND sales.agent_id = a.id) AS total_sales_month'))
        //                     ->where('sales.agent_id', $agent->id)
        //                     ->groupBy('a.id')
        //                     ->orderBy('total_amount_day', 'DESC')
        //                     ->setBindings([$currentDate, $currentMonth, $currentDate, $currentMonth])
        //                     ->get();

        // }


        // $areas = Area::where('status', 1)->get();
        // $premios1 = Premio::where('status', true)->where('type', 1)->get();
        // $premios2 = Premio::where('status', true)->where('type', 2)->get();

        // return view('todayStatistics.index', compact('sales', 'premios1', 'premios2', 'dataUser', 'areas', 'rouletteSpin'));
    }

    public function filterStatistics(Request $request)
    {
        // $dateInit = DateTime::createFromFormat('m/d/Y', $request->dateInit)->format('Y-m-d');
        // $dateEnd = DateTime::createFromFormat('m/d/Y', $request->dateEnd)->format('Y-m-d');

        // $currentDate = Carbon::now()->toDateString();
        // $currentMonth = Carbon::now()->format('Y-m');

        // $agent = Agent::where('area_id', $request->area)->first();

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

        // return response()->json(["view"=>view('todayStatistics.components.tabStatistics', compact('sales'))->render()]);
    }
}