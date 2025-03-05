<?php
namespace App\Services;

use App\Enums\StatusEnum;
use App\Helpers\ResponseHelper;
use App\Http\Requests\AreaRequest;
use App\Http\Requests\StoreareaRequest;
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
            $agent = $this->agentRepository->getAgentByUserId($user_id);
            $areas = $this->areaRepository->getAreas();
            $response = [
                'agent' => $agent,
                'areas' => $areas
            ];

            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $response]);
        } catch (Exception $e) {
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }        
    }
    

    public function saveArea($request)
    {
        $dataArea = new StoreareaRequest([
            'name' => $request->name,
            'description' => $request->desciption,
            'status' => StatusEnum::ACTIVE->value,
        ]);

        DB::beginTransaction();
        try {
            $area = $this->areaRepository->saveArea($dataArea);
            $areas = $this->areaRepository->getAreas();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $areas]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function updateArea($request)
    {
        DB::beginTransaction();
        try {
            $area = $this->areaRepository->getAreaById($request->id);
            $areaData = new StoreareaRequest([
                'name' => $request->name,
                'description' => $request->desciption,
            ]);
            $this->areaRepository->updateArea($area, $areaData);
            DB::commit();
            $areas = $this->areaRepository->getAreas();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $areas]);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function changeStatusArea($request)
    {
        DB::beginTransaction();
        try {
            $area = $this->areaRepository->getAreaById($request->id);
            $response = $this->areaRepository->changeStatusArea($area, $request->status);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $response]);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }        
    }

    public function deleteArea($request)
    {
        DB::beginTransaction();
        try {
            $response = $this->areaRepository->deleteArea($request->id);
            $areas = $this->areaRepository->getAreas();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $areas]);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }        
    }

    public function getAreasData()
    {
        try {
            $agent = $this->agentRepository->getMyAgent();
            $rouletteSpin = $agent->number_turns ?: 0;
            $areas = $this->areaRepository->getAreas();
            $response = [
                'agemt' => $agent,
                'rouletteSpin' => $rouletteSpin,
                'areas' => $areas
            ];
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $response]);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }
}