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
        $areas = Area::get();
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

        $areas = Area::get();

        return response()->json(["view"=>view('area.list.listArea', compact('areas'))->render(), "resp"=>$resp]);
    }

    public function updateArea(Request $request)
    {
        $resp = 0;

        $area = Area::find($request->id);
        $area->name = $request->name;
        $area->description = $request->description;
        if ($area->save()) {
            $resp = 1;
        }

        $areas = Area::get();

        return response()->json(["view"=>view('area.list.listArea', compact('areas'))->render(), "resp"=>$resp]);
    }

    public function changeStatusArea(Request $request)
    {
        $resp = 0;

        $area = Area::find($request->id);
        $area->status = $request->status;
        if ($area->save()) {
            $resp = 1;
        }

        $areas = Area::get();

        return response()->json(["view"=>view('area.list.listArea', compact('areas'))->render(), "resp"=>$resp]);
    }

    public function deleteArea(Request $request)
    {
        $resp = 0;

        $area = Area::find($request->id);
        if ($area->delete()) {
            $resp = 1;
        }

        $areas = Area::get();

        return response()->json(["view"=>view('area.list.listArea', compact('areas'))->render(), "resp"=>$resp]);
    }

    public function edit(area $area)
    {
        //
    }

    public function update(UpdateareaRequest $request, area $area)
    {
        //
    }

    public function destroy(area $area)
    {
        //
    }
}
