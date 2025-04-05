<?php
namespace App\Services;

use App\Enums\StatusEnum;
use App\Helpers\ResponseHelper;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\AreaRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            $user_id = $this->userRepository->getMyUserId();
            $agent = $this->agentRepository->getByUserId($user_id);
            $areas = $this->areaRepository->getAllActive();
            return ResponseHelper::success('Datos de áreas obtenidos correctamente.', [
                'agent' => $agent,
                'areas' => $areas
            ]);
        } catch (Exception $e) {
            Log::error("Error en getDataAreas: " . $e->getMessage());
            return ResponseHelper::error('Error al obtener los datos de áreas.');
        }
    }
    

    public function saveArea(array $data)
    {
        DB::beginTransaction();
        try {
            $areaData = [
                'name' => $data['name'],
                'description' => $data['description'],
                'status' => StatusEnum::ACTIVE->value,
            ];
            $this->areaRepository->save($areaData);
            DB::commit();
            return ResponseHelper::success('Área guardada correctamente.', [
                'areas' => $this->areaRepository->getAllActive()
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en saveArea: " . $e->getMessage());
            return ResponseHelper::error('Error al guardar el área.');
        }
    }

    public function updateArea(array $data)
    {
        DB::beginTransaction();
        try {
            $area = $this->areaRepository->findById($data['id']);
            if (!$area) return ResponseHelper::error('El área no existe.');
            $areaData = [
                'name' => $data['name'],
                'description' => $data['description'],
            ];
            $this->areaRepository->update($area, $areaData);
            DB::commit();
            return ResponseHelper::success('Área actualizada correctamente.', [
                'areas' => $this->areaRepository->getAllActive()
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en updateArea: " . $e->getMessage());
            return ResponseHelper::error('Error al actualizar el área.');
        }
    }

    public function changeStatusArea(int $areaId, string $status)
    {
        DB::beginTransaction();
        try {
            $area = $this->areaRepository->findById($areaId);
            if (!$area) return ResponseHelper::error('El área no existe.');
            $response = $this->areaRepository->changeStatus($area->id, $status);
            DB::commit();
            return ResponseHelper::success('Estado del área actualizado correctamente.', ['response' => $response]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en changeStatusArea: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del área.');
        }
    }

    public function deleteArea(int $areaId)
    {
        DB::beginTransaction();
        try {
            $area = $this->areaRepository->findById($areaId);
            if (!$area) return ResponseHelper::error('El área no existe.');
            $this->areaRepository->delete($areaId);
            DB::commit();
            return ResponseHelper::success('Área eliminada correctamente.', [
                'areas' => $this->areaRepository->getAllActive()
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en deleteArea: " . $e->getMessage());
            return ResponseHelper::error('Error al eliminar el área.');
        }
    }

    public function getAreasData()
    {
        try {
            $agent = $this->agentRepository->getMyAgent();
            if (!$agent) return ResponseHelper::error('No se encontró el agente.');
            return ResponseHelper::success('Datos de áreas obtenidos correctamente.', [
                'agent' => $agent,
                'rouletteSpin' => $agent->number_turns ?: 0,
                'areas' => $this->areaRepository->getAllActive()
            ]);
        } catch (Exception $e) {
            Log::error("Error en getAreasData: " . $e->getMessage());
            return ResponseHelper::error('Error al obtener los datos de las áreas.');
        }
    }
}