<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Commission;
use App\Models\Customers;
use App\Models\ExchangeRate;
use App\Models\Percent;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $percents = Percent::where('status', true)->get();
        $commissions = Commission::where('status', true)->get();
        $exchange_rates = ExchangeRate::where('status', true)->get();
        $sales = Sales::where('status', true)->orderBy('date_admission')->take(10)->get();
        return view('venta.index', compact('percents', 'commissions', 'exchange_rates', 'sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchCustomer(Request $request)
    {
        $client = Customers::where('dni', $request->dni)->first();
        $name = $client->name . " " . $client->lastname;
        return response()->json(["name"=>$name]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveSale(Request $request)
    {
        $client = Customers::where('dni', $request->dniCustomer)->first();
        $agent = Agent::where('user_id', Auth::id())->first();

        $sale = new Sales();
        $sale->date_admission = Carbon::now();
        $sale->amount = $request->amount;
        $sale->observation = $request->observation;
        $sale->status = true;
        $sale->customer_id = $client->id;
        $sale->percent_id = $request->percent_id;
        $sale->commission_id = $request->commission_id;
        $sale->exchange_rate_id = $request->exchange_rate_id;
        $sale->agent_id = 1;
        $sale->action_id = 1;
        if ($sale->save()) {
            $resp = 1;
        }

        $sales = Sales::where('status', true)->orderBy('date_admission')->take(10)->get();

        return response()->json(["view"=>view('venta.list.listSale', compact('sales'))->render(), "resp"=>$resp]);
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
