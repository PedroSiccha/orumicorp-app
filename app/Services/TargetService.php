<?php
namespace App\Services;

use App\Enums\StatusEnum;
use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreTargetRequest;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\TargetRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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
            $dataTarget = new StoreTargetRequest([
                'amount' => $request->amount,
                'month' => date("m"),
                'observation' => $request->observation,
                'status' => StatusEnum::ACTIVE->value,
                'agent_id' => $agent->id
            ]);
            $target = $this->targetRepository->saveTarget($dataTarget);
            $targetMensual = $this->targetRepository->getTargetByMonthAgent(date("m"), $agent);
            $targets = $this->targetRepository->getTargetWithDate();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $targets]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
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
            $targetMensual = $this->targetRepository->getTargetByMonthAgent(date("m"), $agent->id);
            $targets = $this->targetRepository->getTargetWithDate();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $targets]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function addTarget($request)
    {
        DB::beginTransaction();
        try {
            $agent = $this->agentRepository->getMyAgent();
            $target = $this->targetRepository->findTargetById($request->targetId);
            $response = $this->targetRepository->updateAmountTarget($target, $target->amount);
            DB::commit();
            $targetMensual = $this->targetRepository->getTargetByMonthAgent(date("m"), $agent->id);
            $targets = $this->targetRepository->getTargetWithDate();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $targets]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }
}