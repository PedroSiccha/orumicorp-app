<?php

namespace App\Http\Controllers;

use App\Http\Requests\AreaRequest;
use App\Models\Area;
use App\Http\Requests\StoreareaRequest;
use App\Http\Requests\UpdateareaRequest;
use App\Models\Agent;
use App\Models\Customers;
use App\Models\Premio;
use App\Services\AreaService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AreaController extends Controller
{
    protected $areaService;

    public function __construct(AreaService $areaService) {
        $this->areaService = $areaService;
    }

    public function index()
    {
        try {
            $data = $this->areaService->getAreasData();
            $areas = $data->areas;
            $dataUser = $data->dataUser;
            $rouletteSpin = $data->rouletteSpin;
            return view('area.index', compact('areas', 'premios1', 'premios2', 'dataUser', 'rouletteSpin'));
        } catch (Exception $e) {
            Log::error("Error en AreaController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar las áreas.');
        }
    }

    public function saveArea(AreaRequest $request)
    {
        try {
            $data = $this->areaService->saveArea($request);
            $areas = $data->areas;
            return response()->json(["view"=>view('area.list.listArea', compact('areas'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en AreaController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar las áreas.');
        }
        // $resp = 0;

        // $area = new Area();
        // $area->name = $request->name;
        // $area->description = $request->description;
        // $area->status = true;
        // if ($area->save()) {
        //     $resp = 1;
        // }

        // $areas = Area::get();
        
    }

    public function updateArea(AreaRequest $request)
    {
        try {
            $data = $this->areaService->updateArea($request);
            $areas = $data->areas;
            return response()->json(["view"=>view('area.list.listArea', compact('areas'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en AreaController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar las áreas.');
            //throw $th;
        }
        // $resp = 0;

        // $area = Area::find($request->id);
        // $area->name = $request->name;
        // $area->description = $request->description;
        // if ($area->save()) {
        //     $resp = 1;
        // }

        // $areas = Area::get();
        
    }

    public function changeStatusArea(AreaRequest $request)
    {
        try {
            $data = $this->areaService->changeStatusArea($request);
            $areas = $data->areas;
            return response()->json(["view"=>view('area.list.listArea', compact('areas'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en AreaController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar las áreas.');
        }
        // $resp = 0;

        // $area = Area::find($request->id);
        // $area->status = $request->status;
        // if ($area->save()) {
        //     $resp = 1;
        // }

        // $areas = Area::get();

        // return response()->json(["view"=>view('area.list.listArea', compact('areas'))->render(), "resp"=>$resp]);
    }

    public function deleteArea(AreaRequest $request)
    {
        try {
            $data = $this->areaService->deleteArea($request);
            $areas = $data->areas;
            return response()->json(["view"=>view('area.list.listArea', compact('areas'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en AreaController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar las áreas.');
        }
        // $resp = 0;

        // $area = Area::find($request->id);
        // if ($area->delete()) {
        //     $resp = 1;
        // }

        // $areas = Area::get();

        // return response()->json(["view"=>view('area.list.listArea', compact('areas'))->render(), "resp"=>$resp]);
    }

}
