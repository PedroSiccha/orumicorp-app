<?php
namespace App\Services;

use App\Enums\AssistanceType;
use App\Enums\MovementType;
use App\Helpers\ResponseHelper;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\AssistanceRepositoryInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\PerfilRepositoryInterface;
use App\Interfaces\SalesRepositoryInterface;
use App\Interfaces\TargetRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class PerfilService
{

    protected $perfilRepository, $agentRepository, $clientRepository, $assistanceRepository, $targetRepository, $salesRepository;

    public function __construct(
        PerfilRepositoryInterface $perfilRepository,
        AgentRepositoryInterface $agentRepository,
        ClientRepositoryInterface $clientRepository,
        AssistanceRepositoryInterface $assistanceRepository,
        TargetRepositoryInterface $targetRepository,
        SalesRepositoryInterface $salesRepository
    ) {
      $this->perfilRepository = $perfilRepository;  
      $this->agentRepository = $agentRepository;  
      $this->clientRepository = $clientRepository;  
      $this->assistanceRepository = $assistanceRepository;  
      $this->targetRepository = $targetRepository;  
      $this->salesRepository = $salesRepository;  
    }

    public function getProfileData()
    {
        try {
            $agent = $this->agentRepository->getMyAgent();
            if ($agent->number_turns) {
                $rouletteSpin = $agent->number_turns;
            }
            $dateIn = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::INGRESO, $agent->id);
            $dateBreakIn = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::INGRESO_BREAK, $agent->id); // Assistance::where('date', date('Y-m-d'))->where('type', 'IN-BREAK')->where('agent_id', $agent->id)->first();
            $dateBreakOut = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::VUELTA_BREAK, $agent->id); // Assistance::where('date', date('Y-m-d'))->where('type', 'OUT-BREAK')->where('agent_id', $agent->id)->first();
            $dateOut = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::SALIDA, $agent->id); // Assistance::where('date', date('Y-m-d'))->where('type', 'OUT')->where('agent_id', $agent->id)->first();
            $clients = $this->clientRepository->getClientsByAssignedUser($agent->id, 5);
            $targets = $this->targetRepository->getPaginatedTargetsByAgent($agent->id, 5);
            $sales = $this->salesRepository->getSalesByAgent($agent->id, 5);
            $targetMensual = $this->targetRepository->getTargetByMonthAndAgent(date("m"), $agent->id);
            $ingresosActuales = $this->salesRepository->getAmountDateByAgent($agent, MovementType::INGRESOS);
            $amountRetiro = $this->salesRepository->getAmountDateByAgent($agent, MovementType::EGRESOS);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $targetMensual]);
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }
}