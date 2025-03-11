<?php
namespace App\Services;

use App\Enums\StatusEnum;
use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreTargetRequest;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\TargetRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TargetService
{

    protected $targetRepository, $agentRepository;

    public function __construct(
        TargetRepositoryInterface $targetRepository,
        AgentRepositoryInterface $agentRepository
    ) {
      $this->targetRepository = $targetRepository;  
      $this->agentRepository = $agentRepository;
    }

    public function saveTarget($request)
    {
        try {
            $agent = $this->agentRepository->getMyAgent();
            $dataTarget = [
                'amount' => $request->amount,
                'month' => date("m"),
                'observation' => $request->observation,
                'status' => StatusEnum::ACTIVE->value,
                'agent_id' => $agent->id
            ];
            $target = $this->targetRepository->saveTarget($dataTarget);
            $targetMensual = $this->targetRepository->getTargetByMonthAndAgent(date("m"), $agent->id);
            $targets = $this->targetRepository->getTargetsWithMonthName();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $targets]);
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function updateTarget($request)
    {
        DB::beginTransaction();
        try {
            $agent = $this->agentRepository->getMyAgent();
            $target = $this->targetRepository->findTargetById($request->targetId);
            $dataTarget = new StoreTargetRequest([
                'amount' => $request->amount
            ]);
            $response = $this->targetRepository->updateTarget($target, $request);
            DB::commit();
            $targetMensual = $this->targetRepository->getTargetByMonthAndAgent(date("m"), $agent->id);
            $targets = $this->targetRepository->getTargetsWithMonthName();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $targets]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }
    public function addTarget($request)
    {
        DB::beginTransaction(); // Iniciar la transacción
    
        try {
            // Obtener el agente autenticado
            $agent = $this->agentRepository->getMyAgent();
            if (!$agent) {
                return ResponseHelper::error('No se encontró el agente.');
            }
    
            // Buscar la meta y validar que exista
            $target = $this->targetRepository->findTargetById($request->targetId);
            if (!$target) {
                return ResponseHelper::error('No se encontró la meta especificada.');
            }
    
            // Actualizar la cantidad de la meta (ajustar la lógica según sea necesario)
            $nuevoMonto = $target->amount + $request->incremento; // Asumiendo que se envía un valor de incremento
            $response = $this->targetRepository->incrementTargetAmount($target, $nuevoMonto);
    
            DB::commit(); // Confirmar la transacción
    
            // Obtener los datos actualizados
            $targetMensual = $this->targetRepository->getTargetByMonthAndAgent(date("m"), $agent->id);
            $targets = $this->targetRepository->getTargetsWithMonthName();
    
            return ResponseHelper::success('Meta actualizada correctamente.', ['response' => $targets]);
    
        } catch (Exception $e) {
            DB::rollBack(); // Revertir cambios en caso de error
            Log::error("Error en addTarget: " . $e->getMessage());
            return ResponseHelper::error('Error al actualizar la meta.');
        }
    }
    
}