<?php
namespace App\Services;

use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\CampaingRepositoryInterface;
use App\Interfaces\ClientStatusRepositoryInterface;
use App\Interfaces\MaintenanceRepositoryInterface;
use App\Interfaces\PlatformRepositoryInterface;
use App\Interfaces\ProviderRepositoryInterface;
use App\Interfaces\TraidingRepositoryInterface;
use App\Interfaces\TransactionTypeRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;

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
        // $user_id = Auth::user()->id;
        $user = $this->userRepository->findUser();
        // $user = User::where('id', $user_id)->first();
        $roles = $user->getRoleNames()->first();
        $agent = $this->agentRepository->getAgentByUserId($user->id); // Agent::where('user_id', $user_id)->first();
        // $dataUser = $agent;
        // $premios1 = Premio::where('status', true)->where('type', 1)->get();
        // $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $rouletteSpin = $agent->number_turns ?: 0;

        // $customerStatusController = new CustomerStatusController();
        // $customersStatus = $customerStatusController->index();

        $customersStatus = $this->customersStatusRepository->getStatus();
        $campaigns = $this->campaingRepository->getCampaing(); // Campaing::get();
        $suppliers = $this->providerRepository->getProviders(); // Provider::get();
        $platforms = $this->platformRepository->getPlatforms();
        $traidings = $this->traidingRepository->getTraidings();
        $transactionsType = $this->transactionsType->getTransactionTypes();
        // return view('maintenance.index', compact('premios1', 'premios2', 'rouletteSpin', 'dataUser', 'customersStatus', 'campaigns', 'suppliers', 'platforms', 'traidings', 'transactionsType'));
    }
}