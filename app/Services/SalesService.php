<?php
namespace App\Services;

use App\Enums\ActionType;
use App\Enums\StatusEnum;
use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreSalesRequest;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\AreaRepositoryInterface;
use App\Interfaces\AwardRepositoryInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\ComissionRepositoryInterface;
use App\Interfaces\ExchangeRateRepository;
use App\Interfaces\PercentRepositoryInterface;
use App\Interfaces\SalesRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SalesService
{

    protected $salesRepository, $userRepository, $agentRepository, $awardRepository, $clientRepository, $percentRepository, $comissionRepository, $exchangeRateRepository, $areaRepository;

    public function __construct(
        SalesRepositoryInterface $salesRepository,
        UserRepositoryInterface $userRepository,
        AgentRepositoryInterface $agentRepository,
        AwardRepositoryInterface $awardRepository,
        ClientRepositoryInterface $clientRepository,
        PercentRepositoryInterface $percentRepository,
        ComissionRepositoryInterface $comissionRepository,
        ExchangeRateRepository $exchangeRateRepository,
        AreaRepositoryInterface $areaRepository
    ) {
        $this->salesRepository = $salesRepository;
        $this->userRepository = $userRepository;
        $this->agentRepository = $agentRepository;
        $this->awardRepository = $awardRepository;
        $this->clientRepository = $clientRepository;
        $this->percentRepository = $percentRepository;
        $this->comissionRepository = $comissionRepository;
        $this->exchangeRateRepository = $exchangeRateRepository;
        $this->areaRepository = $areaRepository;
    }

    public function saveSale($request)
    {
        try {
            $user = $this->userRepository->getUser();
            $agent = $this->agentRepository->getMyAgent();
            $premio = $this->awardRepository->findAwardByName($request->premio);
            $dataSale = new StoreSalesRequest([
                'date_admission' => Carbon::now(),
                'amount' => $premio->value,
                'observation' => $request->observation,
                'status' => StatusEnum::ACTIVE->value,
                'commission' => $premio->value,
                'agent_id' => $agent->id,
                'action_id' => ActionType::BONUS->value,
                'user_id' => $user->id,
            ]);
            $sale = $this->salesRepository->saveSale($dataSale);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $sale]);
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

    public function getSaleData()
    {
        try {
            $user = $this->userRepository->getUser();
            $roles = $user->getRoleNames()->first();
            $agent = $this->agentRepository->getMyAgent();
            $rouletteSpin = $agent->number_turns ?: 0;
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $previousMonth = Carbon::now()->subMonth()->month;
            $previousYear = Carbon::now()->subMonth()->year;
            $percents = $this->percentRepository->getPercents();
            $commissions = $this->comissionRepository->getComissions();
            $exchange_rates = $this->exchangeRateRepository->getExchangesRate();
            $sales = $this->salesRepository->getSalesByActionAdmission(1, $roles, $currentMonth, $currentYear, $previousMonth, $previousYear);
            $totalAmount = $sales->sum('amount');
            $areas = $this->areaRepository->getAreas();
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

    public function filterSales(Request $request)
    {
        try {
            if (preg_match('/\d{2}\/\d{2}\/\d{4}/', $request->dateInit)) {
                $dateParts = explode('/', $request->dateInit);
                if ((int)$dateParts[0] > 12) {
                    $dateInit = Carbon::createFromFormat('d/m/Y', $request->dateInit)->startOfDay();
                } else {
                    $dateInit = Carbon::createFromFormat('m/d/Y', $request->dateInit)->startOfDay();
                }
            } else {
                throw new Exception("Formato de fecha inválido en dateInit.");
            }
    
            if (preg_match('/\d{2}\/\d{2}\/\d{4}/', $request->dateEnd)) {
                $dateParts = explode('/', $request->dateEnd);
                if ((int)$dateParts[0] > 12) {
                    $dateEnd = Carbon::createFromFormat('d/m/Y', $request->dateEnd)->endOfDay();
                } else {
                    $dateEnd = Carbon::createFromFormat('m/d/Y', $request->dateEnd)->endOfDay();
                }
            } else {
                throw new Exception("Formato de fecha inválido en dateEnd.");
            }
    
        } catch (Exception $e) {
            Log::error('Error en conversión de fechas: ' . $e->getMessage());
            return response()->json(['error' => 'Formato de fecha inválido'], 400);
        }
    
        $codigo = $request->code;
        $areaId = $request->area;
    
        Log::info([
            'Filtrando Ventas desde' => $dateInit->toDateTimeString(),
            'Hasta' => $dateEnd->toDateTimeString(),
            'Fecha desde Request' => $request->dateInit,
            'Fecha hasta Request' => $request->dateEnd
        ]);

        $sales = $this->salesRepository->filterSalesByDate($codigo, $areaId, $dateInit, $dateEnd);

        

        $totalAmount = $sales->sum('amount');
        return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $totalAmount]);
    }

    public function updateSale($request)
    {
        try {
            $agent = $this->agentRepository->findAgentByCode($request->eCodAgent);
            $sale = $this->salesRepository->findSaleById($request->saleId);
            $user = $this->userRepository->getUser();
            $roles = $user->getRoleNames()->first();
            if ($request->typeSales == 3) {
                $commission = (-1)*$request->eComission;
            } else {
                $commission = $request->eComission;
            }

            if ($request->eAmount) {
                $amount = $request->eAmount;
            } else {
                $amount = $commission;
            }

            $dataSale = new StoreSalesRequest([
                'amount' => $amount,
                'observation' => $request->observation,
                'status' => StatusEnum::ACTIVE->value,
                'percent' => $request->percent,
                'commission' => $commission,
                'exchange_rate' => $request->typeChange,
                'agent_id' => $agent->id,
                'action_id' => $request->typeSales,
                'user_id' => $user->id,
            ]);

            $sale = $this->salesRepository->updateSale($sale, $dataSale);

        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $previousMonth = Carbon::now()->subMonth()->month;
        $previousYear = Carbon::now()->subMonth()->year;

        switch ($request->typeSales) {
            case 1:

                $sales = $this->salesRepository->getSalesByActionAdmission($request->typeSales, $roles, $currentMonth, $currentYear, $previousMonth, $previousYear);
                $totalAmount = $sales->sum('amount');

                return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $totalAmount]);
                break;
            case 2:
                $bonusAgent = $this->salesRepository->getBonusAction([2, 3]);
                return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $bonusAgent]);
                break;
            case 3:
                $bonusAgent = $this->salesRepository->getBonusAction([2, 3]);
                return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $bonusAgent]);
                break;
            default:
                echo "Opción no válida";
        }
    }
}