<?php
namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\AreaRepositoryInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\SalesRepositoryInterface;
use App\Interfaces\StatysticsRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StatisticsService
{

    protected $statysticsrepository, $userRepository, $agentRepository, $clientRepository, $saleRepository, $areaRepository;

    public function __construct(
        StatysticsRepositoryInterface $statysticsrepository,
        UserRepositoryInterface $userRepository,
        AgentRepositoryInterface $agentRepository,
        ClientRepositoryInterface $clientRepository,
        SalesRepositoryInterface $saleRepository,
        AreaRepositoryInterface $areaRepository
    ) {
      $this->statysticsrepository = $statysticsrepository;
      $this->userRepository = $userRepository;
      $this->agentRepository = $agentRepository;
      $this->clientRepository = $clientRepository;
      $this->saleRepository = $saleRepository;
      $this->areaRepository = $areaRepository; 
    }

    public function getStatisticsTodayData()
    {
        try {
            $user = $this->userRepository->getCurrentUser();
            $roles = $user->getRoleNames()->first();
            $agent = $this->agentRepository->getByUserId($user->id);
            $rouletteSpin = $agent->number_turns ?: 0;
            $currentDate = Carbon::now()->toDateString();
            $currentMonth = Carbon::now()->format('Y-m');
            $sales = $this->saleRepository->getSalesByActionBetweenDate(4, $currentDate, $currentMonth, $roles, $agent);
            $areas = $this->areaRepository->getAllActive();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $sales]);
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function filterStatistics(Request $request)
    {
        try {
            $dateInit = DateTime::createFromFormat('m/d/Y', $request->dateInit)->format('Y-m-d');
            $dateEnd = DateTime::createFromFormat('m/d/Y', $request->dateEnd)->format('Y-m-d');
            $currentDate = Carbon::now()->toDateString();
            $currentMonth = Carbon::now()->format('Y-m');
            $user = $this->userRepository->getCurrentUser();
            $roles = $user->getRoleNames()->first();
            $agent = $this->agentRepository->getByUserId($user->id);
            $sales = $this->saleRepository->getSalesByActionBetweenDate(4, $currentDate, $currentMonth, $roles, $agent);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $sales]);
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }
}