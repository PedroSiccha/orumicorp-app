<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class AreaService
{
    public function getDataAreas() 
    {
        $user_id = Auth::user()->id;
        $agent = $this->agentRepository->getAgentByUserId(); // Agent::where('user_id', $user_id)->first();
        $areas = $this->agentRepository->getAreas(); // Area::get();
    }

    public function saveArea($request)
    {
        DB::beginTransaction();
        try {
            $area = $this->areaRepository->saveArea($request);
            DB::commit();
            // $area = new Area();
            // $area->name = $request->name;
            // $area->description = $request->description;
            // $area->status = true;
            // if ($area->save()) {
                
            //     return response()->json(["resp"=>1]);
            // }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["resp"=>0]);
        }
        
        $areas = $this->agentRepository->getAreas();
    }

    public function updateArea($request)
    {
        DB::beginTransaction();
        try {
            $area = $this->areaRepository->updateArea($request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["resp"=>0]);
        }
        // $resp = 0;
        // $area = Area::find($request->id);
        // $area->name = $request->name;
        // $area->description = $request->description;
        // if ($area->save()) {
        //     $resp = 1;
        // }
        $areas = $this->agentRepository->getAreas();
        // $areas = Area::get();
    }

    public function changeStatusArea($request)
    {
        
        $area = $this->areaRepository->getAreaById(); // Area::find($request->id);
        try {
            $response = $this->areaRepository->changeStatusArea($request);
            $area->status = $request->status;
            if ($area->save()) {
                $resp = 1;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        $areas = $this->agentRepository->getAreas(); // Area::get();
        
    }

    public function deleteArea($request)
    {
        $area = $this->areaRepository->getAreaById(); // Area::find($request->id);
        $response = $this->areaRepository->deleteArea($area);

        // if ($area->delete()) {
        //     $resp = 1;
        // }
        $areas = $this->agentRepository->getAreas(); // Area::get();
        
    }
}