<?php
namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\CampaingRepositoryInterface;
use App\Interfaces\ClientStatusRepositoryInterface;
use App\Interfaces\MaintenanceRepositoryInterface;
use App\Interfaces\PlatformRepositoryInterface;
use App\Interfaces\ProviderRepositoryInterface;
use App\Interfaces\TraidingRepositoryInterface;
use App\Interfaces\TransactionTypeRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class MaintenanceService
{

    protected $maintenanceRepository, $userRepository, $agentRepository, $customersStatusRepository, $campaingRepository, $providerRepository, $platformRepository, $traidingRepository, $transactionsType;

    public function __construct(
        MaintenanceRepositoryInterface $maintenanceRepository,
        UserRepositoryInterface $userRepository,
        AgentRepositoryInterface $agentRepository,
        ClientStatusRepositoryInterface $customersStatusRepository,
        CampaingRepositoryInterface $campaingRepository,
        ProviderRepositoryInterface $providerRepository,
        PlatformRepositoryInterface $platformRepository,
        TraidingRepositoryInterface $traidingRepository,
        TransactionTypeRepositoryInterface $transactionsType
    ) {
        $this->maintenanceRepository = $maintenanceRepository;        
        $this->userRepository = $userRepository;        
        $this->agentRepository = $agentRepository;        
        $this->customersStatusRepository = $customersStatusRepository;        
        $this->campaingRepository = $campaingRepository;        
        $this->providerRepository = $providerRepository;        
        $this->platformRepository = $platformRepository;        
        $this->traidingRepository = $traidingRepository;        
        $this->transactionsType = $transactionsType;        
    }

    public function getMaintenanceData()
    { 
        try {
            // Obtener el agente y validar su existencia
            $agent = $this->agentRepository->getMyAgent();
            if (!$agent) {
                return ResponseHelper::error('No se encontró un agente asignado al usuario.');
            }

            // Obtener datos necesarios para la vista de mantenimiento
            $customersStatus = $this->customersStatusRepository->getAll();
            $campaigns = $this->campaingRepository->getActiveCampaigns();
            $suppliers = $this->providerRepository->getAll();
            $platforms = $this->platformRepository->getActivePlatforms();
            $traidings = $this->traidingRepository->getActiveTraidings();
            $transactionsType = $this->transactionsType->getTransactionTypes();

            // Construir la respuesta con todos los datos necesarios
            $response = [
                'agent' => $agent,
                'rouletteSpin' => $agent->number_turns ?: 0,
                'customersStatus' => $customersStatus,
                'campaigns' => $campaigns,
                'suppliers' => $suppliers,
                'platforms' => $platforms,
                'traidings' => $traidings,
                'transactionsType' => $transactionsType
            ];

            return ResponseHelper::success('Datos de mantenimiento obtenidos correctamente.', $response);

        } catch (Exception $e) {
            Log::error("Error en getMaintenanceData: " . $e->getMessage());
            return ResponseHelper::error('Error al obtener los datos de mantenimiento.');
        }
    }

}