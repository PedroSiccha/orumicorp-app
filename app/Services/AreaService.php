<?php
namespace App\Services;

use App\Http\Requests\AreaRequest;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\AreaRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class AreaService
{

    protected $userRepository;
    protected $areaRepository;
    protected $agentRepository;

    public function __construct(
        AreaRepositoryInterface $areaRepository,
        UserRepositoryInterface $userRepository,
        AgentRepositoryInterface $agentRepository
    ) {
        $this->areaRepository = $areaRepository;
        $this->userRepository = $userRepository;
        $this->agentRepository = $agentRepository;
    }

    public function getDataAreas() 
    {
        try {
            $user_id = $this->userRepository->getMyId();
            $agent = $this->agentRepository->getAgentByUserId($user_id); // Agent::where('user_id', $user_id)->first();
            $areas = $this->areaRepository->getAreas(); // Area::get();
        } catch (Exception $e) {
            //throw $th;
        }
        
    }
    

    public function saveArea(AreaRequest $request)
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
        
        $areas = $this->areaRepository->getAreas();
    }

    public function updateArea($request)
    {
        DB::beginTransaction();
        try {
            $area = $this->areaRepository->updateArea($request->id, $request);
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
        $areas = $this->areaRepository->getAreas();
        // $areas = Area::get();
    }

    public function changeStatusArea($request)
    {
        
        $area = $this->areaRepository->getAreaById($request->id);
        try {
            $response = $this->areaRepository->changeStatusArea($request->id, $request->status);
            $area->status = $request->status;
            if ($area->save()) {
                $resp = 1;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        $areas = $this->areaRepository->getAreas(); // Area::get();
        
    }

    public function deleteArea($request)
    {
        try {
            $area = $this->areaRepository->getAreaById($request->id);
            $response = $this->areaRepository->deleteArea($area);
        } catch (\Throwable $th) {
            //throw $th;
        }
        

        // if ($area->delete()) {
        //     $resp = 1;
        // }
        $areas = $this->areaRepository->getAreas(); // Area::get();
        
    }

    public function getAreasData()
    {
        // $user_id = Auth::user()->id;

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

        // $premios1 = Premio::where('status', true)->where('type', 1)->get();
        // $premios2 = Premio::where('status', true)->where('type', 2)->get();
        // $areas = Area::get();
        $areas = $this->areaRepository->getAreas();
    }
}