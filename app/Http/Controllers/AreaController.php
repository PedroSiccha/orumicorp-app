<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Http\Requests\StoreareaRequest;
use App\Http\Requests\UpdateareaRequest;
use App\Models\Agent;
use App\Models\Customers;
use App\Models\Premio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;

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

        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $areas = Area::where('status', true)->get();
        return view('area.index', compact('areas', 'premios1', 'premios2', 'dataUser', 'rouletteSpin'));
    }

    public function saveArea(Request $request)
    {
        $resp = 0;

        $area = new Area();
        $area->name = $request->name;
        $area->description = $request->description;
        $area->status = true;
        if ($area->save()) {
            $resp = 1;
        }

        $areas = Area::where('status', true)->get();

        return response()->json(["view"=>view('area.list.listArea', compact('areas'))->render(), "resp"=>$resp]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateArea(Request $request)
    {
        $resp = 0;

        $area = Area::find($request->id);
        $area->name = $request->name;
        $area->description = $request->description;
        if ($area->save()) {
            $resp = 1;
        }

        $areas = Area::where('status', true)->get();

        return response()->json(["view"=>view('area.list.listArea', compact('areas'))->render(), "resp"=>$resp]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreareaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function changeStatusArea(Request $request)
    {
        $resp = 0;

        $area = Area::find($request->id);
        $area->status = false;
        if ($area->save()) {
            $resp = 1;
        }

        $areas = Area::where('status', true)->get();

        return response()->json(["view"=>view('area.list.listArea', compact('areas'))->render(), "resp"=>$resp]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\area  $area
     * @return \Illuminate\Http\Response
     */
    public function deleteArea(Request $request)
    {
        $resp = 0;

        $area = Area::find($request->id);
        if ($area->delete()) {
            $resp = 1;
        }

        $areas = Area::where('status', true)->get();

        return response()->json(["view"=>view('area.list.listArea', compact('areas'))->render(), "resp"=>$resp]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(area $area)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateareaRequest  $request
     * @param  \App\Models\area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateareaRequest $request, area $area)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(area $area)
    {
        //
    }
}
