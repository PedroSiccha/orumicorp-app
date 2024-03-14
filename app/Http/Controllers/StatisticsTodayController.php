<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Area;
use App\Models\Customers;
use App\Models\Premio;
use App\Models\Sales;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticsTodayController extends Controller
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

        $dataUser = null;

        if ($agent) {
            $dataUser = $agent;
        }

        if ($client) {
            $dataUser = $client;
        }
        if ($roles == 'ADMINISTRADOR') {
            $sales = Sales::join('agents as a', 'sales.agent_id', '=', 'a.id')
                        ->selectRaw('a.name, a.lastname,
                                    DATE(sales.date_admission) AS day,
                                    MONTH(sales.date_admission) AS month,
                                    SUM(CASE WHEN sales.action_id = 4 THEN sales.amount ELSE 0 END) AS total_amount_action_4,
                                    SUM(sales.amount) AS total_amount_day,
                                    SUM(sales.amount) AS total_amount_month')
                        ->groupBy('a.name', 'a.lastname', 'day', 'month')
                        ->get();
        } else {
            $sales = Sales::join('agents as a', 'sales.agent_id', '=', 'a.id')
            ->selectRaw('a.name, a.lastname,
                        DATE(sales.date_admission) AS day,
                        MONTH(sales.date_admission) AS month,
                        SUM(CASE WHEN sales.action_id = 4 THEN sales.amount ELSE 0 END) AS total_amount_action_4,
                        SUM(sales.amount) AS total_amount_day,
                        SUM(sales.amount) AS total_amount_month')
                        ->where('sales.agent_id', $agent->id)
            ->groupBy('a.name', 'a.lastname', 'day', 'month')
            ->get();
        }


        $areas = Area::where('status', 1)->get();
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();

        return view('todayStatistics.index', compact('sales', 'premios1', 'premios2', 'dataUser', 'areas', 'rouletteSpin'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filterStatistics(Request $request)
    {
        $dateInit = DateTime::createFromFormat('m/d/Y', $request->dateInit)->format('Y-m-d');
        $dateEnd = DateTime::createFromFormat('m/d/Y', $request->dateEnd)->format('Y-m-d');

        $agent = Agent::where('area_id', $request->area)->first();

        $sales = Sales::join('agents as a', 'sales.agent_id', '=', 'a.id')
                      ->selectRaw('a.name, a.lastname,
                                   DATE(sales.date_admission) AS day,
                                   MONTH(sales.date_admission) AS month,
                                   SUM(CASE WHEN sales.action_id = 4 THEN sales.amount ELSE 0 END) AS total_amount_action_4,
                                   SUM(sales.amount) AS total_amount_day,
                                   SUM(sales.amount) AS total_amount_month')
                      ->where('a.area_id', $request->area)
                      ->whereBetween('sales.date_admission', [$dateInit, $dateEnd])
                      ->groupBy('a.name', 'a.lastname', 'day', 'month')
                      ->get();

        return response()->json(["view"=>view('todayStatistics.components.tabStatistics', compact('sales'))->render()]);
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
