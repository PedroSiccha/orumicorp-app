<?php
namespace App\Services;

use App\Enums\AssistanceType;
use App\Enums\MovementType;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\AssistanceRepositoryInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\PerfilRepositoryInterface;
use App\Interfaces\SalesRepositoryInterface;
use App\Interfaces\TargetRepositoryInterface;

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
        $agent = $this->agentRepository->getAgentByUserId($id); // Agent::where('user_id', $id)->first();
        $client = $this->clientRepository->getClientByUserId($id); // Customers::where('user_id', $id)->first();
        $rouletteSpin = 0;

        if ($agent->number_turns) {
            $rouletteSpin = $agent->number_turns;
        }

        // $dataUser = null;

        // if ($agent) {
        //     $dataUser = $agent;
        // }

        // if ($client) {
        //     $dataUser = $client;
        // }

        // $premios1 = Premio::where('status', true)->where('type', 1)->get();
        // $premios2 = Premio::where('status', true)->where('type', 2)->get();

        $dateIn = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::INGRESO, $agent->id);
        $dateBreakIn = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::INGRESO_BREAK, $agent->id); // Assistance::where('date', date('Y-m-d'))->where('type', 'IN-BREAK')->where('agent_id', $agent->id)->first();
        $dateBreakOut = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::VUELTA_BREAK, $agent->id); // Assistance::where('date', date('Y-m-d'))->where('type', 'OUT-BREAK')->where('agent_id', $agent->id)->first();
        $dateOut = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::SALIDA, $agent->id); // Assistance::where('date', date('Y-m-d'))->where('type', 'OUT')->where('agent_id', $agent->id)->first();
        $clients = $this->clientRepository->getClientsByAssignedUser($agent->id, 5);

        $targets = $this->targetRepository->getTargetsByAgent($agent->id);
        

        $sales = $this->salesRepository->getSalesByAgent($agent->id, 5);
        $targetMensual = $this->targetRepository->getTargetByMonthAgent(date("m"), $agent->id);
        $ingresosActuales = $this->salesRepository->getAmountDateByAgent($agent, MovementType::INGRESOS);
        $amountRetiro = $this->salesRepository->getAmountDateByAgent($agent, MovementType::EGRESOS);
        
        // return view('profile.index', compact('premios1', 'premios2', 'dataUser', 'rouletteSpin', 'dateIn', 'dateBreakIn', 'dateBreakOut', 'dateOut', 'clients', 'targets', 'sales', 'targetMensual', 'ingresosActuales', 'amountRetiro'));
    }
}