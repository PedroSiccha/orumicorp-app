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
use Illuminate\Validation\ValidationException;

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
            $agent = $this->agentRepository->getMyAgent();
            $rouletteSpin = $agent->number_turns ?: 0;
            $customersStatus = $this->customersStatusRepository->getCustomerStatus();
            $campaigns = $this->campaingRepository->getCampaing();
            $suppliers = $this->providerRepository->getProviders();
            $platforms = $this->platformRepository->getPlatforms();
            $traidings = $this->traidingRepository->getTraidings();
            $transactionsType = $this->transactionsType->getTransactionTypes();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $transactionsType]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }
}