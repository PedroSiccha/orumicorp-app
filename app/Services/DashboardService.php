<?php
namespace App\Services;

use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\ProviderRepositoryInterface;
use App\Interfaces\SalesRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;

class DashboardService
{

    protected $userRepository, $agentRepository, $salesRepository, $providerRepository, $clientRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AgentRepositoryInterface $agentRepository,
        SalesRepositoryInterface $salesRepository,
        ProviderRepositoryInterface $providerRepository,
        ClientRepositoryInterface $clientRepository
    ) {
        $this->userRepository = $userRepository;
        $this->agentRepository = $agentRepository;
        $this->salesRepository = $salesRepository;
        $this->providerRepository = $providerRepository;
        $this->clientRepository = $clientRepository;
    }

    public function getDashboard() {
        // $user_id = Auth::user()->id;
        // $user = User::where('id', $user_id)->first();
        $user = $this->userRepository->findUser();
        $roles = $user->getRoleNames()->first();

        $agent = $this->agentRepository->getAgentByUserId($user->id); // Agent::where('user_id', $user_id)->first();
        $rouletteSpin = $agent->number_turns ?: 0;

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $previousMonth = Carbon::now()->subMonth()->month;
        $previousYear = Carbon::now()->subMonth()->year;

        $sales = null;
        $totalAmount = 0;

        
        if ($roles == 'ADMINISTRADOR') {
            $sales = $this->salesRepository->getSalesByActionAdmission(1, $currentMonth, $currentYear, $previousMonth, $previousYear);
        //     $sales = Sales::where('status', true)
        //                 ->where('action_id', 1)
        //                 ->where(function ($query) use ($currentMonth, $currentYear, $previousMonth, $previousYear) {
        //                     $query->whereYear('date_admission', $currentYear)->whereMonth('date_admission', $currentMonth)
        //                             ->orWhere(function ($query) use ($previousMonth, $previousYear) {
        //                                 $query->whereYear('date_admission', $previousYear)->whereMonth('date_admission', $previousMonth);
        //                             });
        //                 })
        //                 ->orderBy('date_admission', 'desc')
        //                 ->get();
        } else {
            $sales = $this->salesRepository->getSalesAgentByActionAdmission(1, $currentMonth, $currentYear, $previousMonth, $previousYear, $agent);
        //     if ($agent) {
        //         $sales = Sales::where('status', true)
        //                 ->where('action_id', 1)
        //                 ->where('agent_id', $agent->id)
        //                 ->where(function ($query) use ($currentMonth, $currentYear, $previousMonth, $previousYear) {
        //                     $query->whereYear('date_admission', $currentYear)->whereMonth('date_admission', $currentMonth)
        //                             ->orWhere(function ($query) use ($previousMonth, $previousYear) {
        //                                 $query->whereYear('date_admission', $previousYear)->whereMonth('date_admission', $previousMonth);
        //                             });
        //                 })
        //                 ->orderBy('date_admission', 'desc')
        //                 ->get();
        //     }
        }

        $totalAmount = $sales->sum('amount');

        $agents = $this->agentRepository->getAgents(); //Agent::get();
        $clients = $this->clientRepository->getClients(); // Customers::get();
        $cantAgents = count($agents);
        $cantClients = count($clients);

        $montoVenta = $this->salesRepository->getAmountByArea(1);
        
        $montoRetencion = $this->salesRepository->getAmountByArea(2);
        
        $montosPorAgente = $this->salesRepository->getAmountBySales(10);

        $cantClientsRegisterProvider = 0;
        $percentClientsRegisterProvider = 0;
        $cantClientsActiveProvider = 0;
        $percentClientsActiveProvider = 0;
        $cantClientsProvider = 0;
        $listClientsProvider = [];

        if ($roles == 'PROVEEDOR') {
            $provider = $this->providerRepository->getProviderByUser($user->id);
            $cantClientsRegisterProvider = $this->clientRepository->getCantClientsRegisterByProvider($provider->id, Carbon::now()->month, Carbon::now()->year);
            $cantClientsActiveProvider = $this->clientRepository->getCantClientsActiveByProvider($provider->id, Carbon::now()->month, Carbon::now()->year); // para ver FDT tiebe que estar en activo
            $cantClientsProvider = $this->clientRepository->getCantClientsByProvider($provider->id, Carbon::now()->year);
            if ($cantClientsRegisterProvider > 0) {
                $percentClientsActiveProvider = round(($cantClientsActiveProvider / $cantClientsRegisterProvider) * 100, 2);
            }
            if ($cantClientsProvider > 0) {
                $percentClientsRegisterProvider = round(($cantClientsRegisterProvider / $cantClientsProvider) * 100, 2);
            }
            $listClientsProvider = $this->clientRepository->getListClientsProvider($provider->id, Carbon::now()->month, Carbon::now()->year);
        }
    }
}