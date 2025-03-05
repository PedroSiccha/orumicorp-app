<?php
namespace App\Services;

use App\Enums\ActionType;
use App\Enums\StatusEnum;
use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreBonusAgentRequest;
use App\Http\Requests\StoreSalesRequest;
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
        $user = $this->userRepository->getUser();
        $roles = $user->getRoleNames()->first();
        $agent = $this->agentRepository->getAgentByUserId($user->id);
        $percents = $this->percentRepository->getPercents();
        $commissions = $this->comissionRepository->getComissions();
        $exchange_rates = $this->exchangeRateRepository->getExchangeRates();
        $bonusAgent = $this->salesRepository->getBonusAgent($agent, [1, 2, 3], $roles);
        $target = $this->targetRepository->getTargets();
        $reportTargetMensual = $target->sum('amount') ?: 0;
        $amount = $this->salesRepository->getAmountIngreso();
        $amountRetiro = $this->salesRepository->getAmountEgreso();
        $rouletteSpin = $agent->number_turns ?: 0;
        $areas = $this->areaRepository->getAreas();
        $response = [
            'user' => $user,
            'roles' => $roles,
            'agent' => $agent,
            'percents' => $percents,
            'commissions' => $commissions,
            'exchange_rates' => $exchange_rates,
            'bonusAgent' => $bonusAgent,
            'target' => $target,
            'reportTargetMensual' => $reportTargetMensual,
            'amount' => $amount,
            'amountRetiro' => $amountRetiro,
            'rouletteSpin' => $rouletteSpin,
            'areas' => $areas
        ];
        return ResponseHelper::success('Datos obtenido correctamente.', ['response' => $response]);
    }

    public function saveBonus($data) 
    {
        $user = $this->userRepository->getUser();
        $roles = $user->getRoleNames()->first();

        if ($data->dniCustomer > 0) {
            $client = $this->clientRepository->getClientByCode($data->dniCustomer);
            $client_id = $client->id ?? null;
        }

        $agent = $this->agentRepository->findAgentByCode($data->dniAgent);

        $dataAgentBonus = new StoreBonusAgentRequest([
                'date_admission' => Carbon::now(), 
                'amount' => $data->amount,
                'observation' => $data->observation ?? null,
                'status' => StatusEnum::ACTIVE->value,
                'customer_id' => $client_id ?? null,
                'percent_id' => $data->percent_id ?? null,
                'commission_id' => $data->commission_id ?? null,
                'exchange_rate_id' => $data->exchange_rate_id ?? null,
                'agent_id' => $agent->id,
                'action_id' => 1
            ]) ;

        $dataSale = new StoreSalesRequest([
            'date_admission' => Carbon::now(),
            'amount' => $data->amount,
            'observation' => $data->observation ?? null,
            'status' => StatusEnum::ACTIVE->value,
            'agent_id' => $agent->id,
            'action_id' => ActionType::BONUS->value,
            'user_id' => Auth::user()->id,
        ]);

        DB::beginTransaction();
        try {
            $bonusAgent = $this->agentBonusRepository->saveBonus($dataAgentBonus);
            $sale = $this->salesRepository->saveSale($dataSale);
            DB::commit();
            $bonusAgent = $this->salesRepository->getBonusAgent($agent, [1, 2, 3], $roles);
            return ResponseHelper::success('El bonus se guardó correctamente.', ['response' => $bonusAgent]);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::error('Error al registrar el bonus.');
        }
    }

    public function saveRetiro($data) {
        $agent = $this->agentRepository->findAgentByCode($data->dni);

        $dataSale = new StoreSalesRequest([
            'date_admission' => Carbon::now(),
            'amount' => -1*($data->amount),
            'observation' => $data->observation ?? null,
            'status' => StatusEnum::ACTIVE->value,
            'percent' => $data->percent ?? null,
            'commission' => $data->commission ?? null,
            'exchange_rate' => $data->exchange_rate ?? null,
            'agent_id' => $agent->id,
            'action_id' => ActionType::RETIRO->value,
            'user_id' => Auth::user()->id,
        ]);

        DB::beginTransaction();
        try {
            $sale = $this->salesRepository->saveSale($dataSale);
            DB::commit();
            $bonusAgent = $this->agentBonusRepository->getBonusAgent([1, 2, 3], StatusEnum::ACTIVE->value, 'DESC');
            return ResponseHelper::success('El retiro se guardó correctamente.', ['response' => $bonusAgent]);
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::error('Error al registrar el retiro.');
        }        
    }

    public function filterBonus($data) {
        $dateInit = DateTime::createFromFormat('m/d/Y', $data->dateInit)->format('Y-m-d');
        $dateEnd = DateTime::createFromFormat('m/d/Y', $data->dateEnd)->format('Y-m-d');
        $codigo = $data->code;
        $nombre = $data->code;
        $agent = $this->agentRepository->getMyAgent();
        $area = $this->areaRepository->getAreaById($agent->id);
        $bonusAgent = $this->salesRepository->searchBonusAgent($codigo, $nombre, $area, $dateInit, $dateEnd);
        return ResponseHelper::success('Datos obtenido correctamente.', ['response' => $bonusAgent]);
    }
}