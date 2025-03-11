<?php
namespace App\Services;

use App\Enums\ActionType;
use App\Enums\StatusEnum;
use App\Helpers\ResponseHelper;
use App\Interfaces\AgentBonusRepositoryInterface;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\AreaRepositoryInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\ComissionRepositoryInterface;
use App\Interfaces\ExchangeRepositoryInrterface;
use App\Interfaces\PercentRepositoryInterface;
use App\Interfaces\SalesRepositoryInterface;
use App\Interfaces\TargetRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Exception;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AgentBonusService
{
    protected $userRepository;
    protected $agentRepository;
    protected $percentRepository;
    protected $comissionRepository;
    protected $exchangeRateRepository;
    protected $salesRepository;
    protected $targetRepository;
    protected $areaRepository;
    protected $clientRepository;
    protected $agentBonusRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AgentRepositoryInterface $agentRepository,
        PercentRepositoryInterface $percentRepository,
        ComissionRepositoryInterface $comissionRepository,
        ExchangeRepositoryInrterface $exchangeRateRepository,
        SalesRepositoryInterface $salesRepository,
        TargetRepositoryInterface $targetRepository,
        AreaRepositoryInterface $areaRepository,
        ClientRepositoryInterface $clientRepository,
        AgentBonusRepositoryInterface $agentBonusRepository
    ) {
      $this->userRepository = $userRepository;  
      $this->agentRepository = $agentRepository;
      $this->percentRepository = $percentRepository;
      $this->comissionRepository = $comissionRepository;
      $this->exchangeRateRepository = $exchangeRateRepository;
      $this->salesRepository = $salesRepository;
      $this->targetRepository = $targetRepository;
      $this->areaRepository = $areaRepository;
      $this->clientRepository = $clientRepository;
      $this->agentBonusRepository = $agentBonusRepository;
    }

    public function getDataAgentBonus() {
        try {
            $user = $this->userRepository->getCurrentUser();
            $roles = $user->getRoleNames()->first();
            $agent = $this->agentRepository->getById($user->id);

            if (!$agent) {
                return ResponseHelper::error('Agente no encontrado.');
            }

            $response = [
                'user' => $user,
                'roles' => $roles,
                'agent' => $agent,
                'percents' => $this->percentRepository->getActivePercents(),
                'commissions' => $this->comissionRepository->getActiveCommissions(),
                'exchange_rates' => $this->exchangeRateRepository->getActiveExchangeRates(),
                'bonusAgent' => $this->salesRepository->getBonusAgent([1, 2, 3], true, 'ASC', $agent, $roles),
                'target' => $this->targetRepository->getTargets(),
                'reportTargetMensual' => $this->targetRepository->getTargets()->sum('amount') ?: 0,
                'amount' => $this->salesRepository->getAmountIngreso(),
                'amountRetiro' => $this->salesRepository->getAmountEgreso(),
                'rouletteSpin' => $agent->number_turns ?? 0,
                'areas' => $this->areaRepository->getAllActive(),
            ];

            return ResponseHelper::success('Datos obtenidos correctamente.', ['response' => $response]);
        } catch (Exception $e) {
            Log::error('Error en getDataAgentBonus: ' . $e->getMessage());
            return ResponseHelper::error('Error al obtener los datos.');
        }
    }

    public function saveBonus(array $data)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->getCurrentUser();
            $client = optional($this->clientRepository->getClientByCode($data['dniCustomer'] ?? null));
            $agent = $this->agentRepository->getByCode($data['dniAgent']);

            if (!$agent) {
                return ResponseHelper::error('Agente no encontrado.');
            }

            $dataAgentBonus = [
                'date_admission' => Carbon::now(),
                'amount' => $data['amount'],
                'observation' => $data['observation'] ?? null,
                'status' => StatusEnum::ACTIVE->value,
                'customer_id' => $client->id ?? null,
                'percent_id' => $data['percent_id'] ?? null,
                'commission_id' => $data['commission_id'] ?? null,
                'exchange_rate_id' => $data['exchange_rate_id'] ?? null,
                'agent_id' => $agent->id,
                'action_id' => ActionType::BONUS->value
            ];

            $dataSale = [
                'date_admission' => Carbon::now(),
                'amount' => $data['amount'],
                'observation' => $data['observation'] ?? null,
                'status' => StatusEnum::ACTIVE->value,
                'agent_id' => $agent->id,
                'action_id' => ActionType::BONUS->value,
                'user_id' => Auth::id(),
            ];

            $this->agentBonusRepository->save($dataAgentBonus);
            $this->salesRepository->saveSale($dataSale);

            DB::commit();

            return ResponseHelper::success('El bonus se guardó correctamente.', [
                'response' => $this->salesRepository->getBonusAgent([1, 2, 3], true, $agent,  $user->getRoleNames()->first())
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error en saveBonus: ' . $e->getMessage());
            return ResponseHelper::error('Error al registrar el bonus.');
        }
    }

    public function saveRetiro($data) {

        DB::beginTransaction();
        try {
            $user = $this->userRepository->getCurrentUser();
            $agent = $this->agentRepository->getByCode($data->dni);
            $roles = $user->getRoleNames()->first();

            if (!$agent) {
                return ResponseHelper::error('Agente no encontrado.');
            }

            $dataSale = [
                'date_admission' => Carbon::now(),
                'amount' => -1 * $data['amount'],
                'observation' => $data['observation'] ?? null,
                'status' => StatusEnum::ACTIVE->value,
                'agent_id' => $agent->id,
                'action_id' => ActionType::RETIRO->value,
                'user_id' => Auth::id(),
            ];

            $this->salesRepository->saveSale($dataSale);
            DB::commit();

            return ResponseHelper::success('El retiro se guardó correctamente.', [
                'response' => $this->salesRepository->getBonusAgent([1, 2, 3], true, 'ASC', $agent, $roles)
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error en saveRetiro: ' . $e->getMessage());
            return ResponseHelper::error('Error al registrar el retiro.');
        }
    }

    public function filterBonus($data) {

        try {
            $dateInit = DateTime::createFromFormat('m/d/Y', $data->dateInit)->format('Y-m-d');
            $dateEnd = DateTime::createFromFormat('m/d/Y', $data->dateEnd)->format('Y-m-d');
            $agent = $this->agentRepository->getMyAgent();
            $area = $this->areaRepository->findById($agent->id);

            $bonusAgent = $this->salesRepository->searchBonusAgent($data->code, $data->code, $area, $dateInit, $dateEnd);

            return ResponseHelper::success('Datos obtenidos correctamente.', ['response' => $bonusAgent]);
        } catch (Exception $e) {
            Log::error('Error en filterBonus: ' . $e->getMessage());
            return ResponseHelper::error('Error al filtrar los bonos.');
        }
    }
}