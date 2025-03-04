<?php
namespace App\Services;

use App\Enums\StatusEnum;
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
use Exception;
use DateTime;
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
        $user = $this->userRepository->getUserById();
        $roles = $user->getRoleNames()->first();

        $agent = $this->agentRepository->getAgentByUserId($user->id);

        $percents = $this->percentRepository->getPercents();
        $commissions = $this->comissionRepository->getComissions();
        $exchange_rates = $this->exchangeRateRepository->getExchangeRates();
        $bonusAgent = $this->salesRepository->getBonusAgent($agent, $roles); // Sales::whereIn('action_id', [1, 2, 3]) // Filtra por action_id 1, 2 y 3

        $target = $this->targetRepository->getTargets();

        $reportTargetMensual = $this->targetRepository->getSumAmount($target);
        // if ($target == null) {
        //     $target = new Target();
        //     $target->amount = 0;
        // }

        $amount = $this->salesRepository->getAmountIngreso();
        // $amount = DB::table('sales as s')
        //             ->join('actions as a', 's.action_id', '=', 'a.id')
        //             ->join('movement_types as m', 'a.movement_type_id', '=', 'm.id')
        //             ->where('m.name', 'INGRESO')
        //             ->where('s.status', 1) // Solo incluir ventas activas
        //             ->where('a.status', 1) // Solo incluir acciones activas
        //             ->whereMonth('s.date_admission', date("m")) // Filtrar solo el mes actual
        //             ->value(DB::raw('COALESCE(SUM(s.amount), 0)'));

        $amountRetiro = $this->salesRepository->getAmountEgreso();
        $rouletteSpin = $agent->number_turns ?: 0;
        $areas = $this->areaRepository->getAllAreas(); // Area::where('status', true)->get();
        

        // $percents = Percent::where('status', true)->get();
        // $commissions = Commission::where('status', true)->get();
        // $exchange_rates = ExchangeRate::where('status', true)->get();

        // if ($roles == 'ADMINISTRADOR') {
        //     $bonusAgent = Sales::whereIn('action_id', [1, 2, 3]) // Filtra por action_id 1, 2 y 3
        //                         ->where('status', 1)
        //                         ->orderBy('created_at', 'DESC') // Ordena por fecha de admisión de forma descendente
        //                         ->with('action') // Carga la relación con actions (si está definida en el modelo)
        //                         ->get();
        // } else {

        //     $bonusAgent = Sales::whereIn('action_id', [1, 2, 3]) // Filtra por action_id 1, 2 y 3
        //                         ->where('status', 1)
        //                         ->where('agent_id', $agent->id)
        //                         ->orderBy('created_at', 'DESC') // Ordena por fecha de admisión de forma descendente
        //                         ->with('action') // Carga la relación con actions (si está definida en el modelo)
        //                         ->get();

        // }


        // $target = Target::where('status', true)
        //             ->where('month', date("m"))
        //             ->orderBy("created_at", "asc")
        //             ->get();

        // $reportTargetMensual = $target->sum('amount');

        // if ($target == null) {
        //     $target = new Target();
        //     $target->amount = 0;
        // }

        // $amount = DB::table('sales as s')
        //             ->join('actions as a', 's.action_id', '=', 'a.id')
        //             ->join('movement_types as m', 'a.movement_type_id', '=', 'm.id')
        //             ->where('m.name', 'INGRESO')
        //             ->where('s.status', 1) // Solo incluir ventas activas
        //             ->where('a.status', 1) // Solo incluir acciones activas
        //             ->whereMonth('s.date_admission', date("m")) // Filtrar solo el mes actual
        //             ->value(DB::raw('COALESCE(SUM(s.amount), 0)'));

        // $amountRetiro = DB::table('sales as s')
        //                 ->join('actions as a', 's.action_id', '=', 'a.id')
        //                 ->join('movement_types as m', 'a.movement_type_id', '=', 'm.id')
        //                 ->where('m.name', 'EGRESO')
        //                 ->where('s.status', 1) // Solo incluir ventas activas
        //                 ->where('a.status', 1) // Solo incluir acciones activas
        //                 ->whereMonth('s.date_admission', date("m")) // Filtrar solo el mes actual
        //                 ->value(DB::raw('COALESCE(SUM(s.amount), 0)'));

        // $premios1 = Premio::where('status', true)->where('type', 1)->get();
        // $premios2 = Premio::where('status', true)->where('type', 2)->get();
        // $rouletteSpin = $agent->number_turns ?: 0;
        // $areas = Area::where('status', true)->get();
    }

    public function saveBonus($data) {
        $title = 'Error';
        $mensaje = 'Error desconocido';
        $status = 'error';

        $user = $this->userRepository->getUserById();
        $roles = $user->getRoleNames()->first();

        if ($data->dniCustomer > 0) {
            $client = $this->clientRepository->getClientByCode($data->dniCustomer);
            $client_id = $client->id;
        }

        $codeAgt = $data->dniAgent;
        $amount = $data->amount;
        $observation = $data->observation;

        $agent = $this->agentRepository->findAgentByCode($codeAgt); // Agent::where('code_voiso', $codeAgt)->first();

        DB::beginTransaction();
        try {
            $bonusAgent = $this->agentBonusRepository->saveBonus($data);
            $sale = $this->salesRepository->saveSale($data);
            DB::commit();
            // $bonusAgent = new BonusAgent();
            // $bonusAgent->date_admission = Carbon::now();
            // $bonusAgent->amount = $amount;
            // $bonusAgent->observation = $observation;
            // $bonusAgent->status = true;
            // // $bonusAgent->customer_id = $client_id;
            // if ($request->percent_id > 0) {
            //     $bonusAgent->percent_id = $request->percent_id;
            // }
            // if ($request->commission_id > 0) {
            //     $bonusAgent->commission_id = $request->commission_id;
            // }
            // if ($request->exchange_rate_id > 0) {
            //     $bonusAgent->exchange_rate_id = $request->exchange_rate_id;
            // }
            // $bonusAgent->agent_id = $agent->id;
            // $bonusAgent->action_id = 1;
            // if ($bonusAgent->save()) {

            //     $sale = new Sales();
            //     $sale->date_admission = Carbon::now();
            //     $sale->amount = $amount;
            //     $sale->observation = $observation;
            //     $sale->status = true;
            //     $sale->agent_id = $agent->id;
            //     $sale->action_id = 2;
            //     $sale->user_id = Auth::user()->id;
            //     if ($sale->save()) {
            //         $title = "Correcto";
            //         $mensaje = "Registrado correctamente";
            //         $status = "success";
            //     }
            // }
        } catch (Exception $e) {
            DB::rollBack();
            $title = 'Error';
            $mensaje = 'Ocurrió un error: '.$e->getMessage();
            $status = 'error';
        }

        $bonusAgent = $this->salesRepository->getBonusAgent($agent, $roles);

        // if ($roles == 'ADMINISTRADOR') {
        //     $bonusAgent = Sales::whereIn('action_id', [1, 2, 3]) // Filtra por action_id 1, 2 y 3
        //                         ->where('status', 1)
        //                         ->orderBy('created_at', 'DESC') // Ordena por fecha de admisión de forma descendente
        //                         ->with('action') // Carga la relación con actions (si está definida en el modelo)
        //                         ->get();
        // } else {

        //     $bonusAgent = Sales::whereIn('action_id', [1, 2, 3]) // Filtra por action_id 1, 2 y 3
        //                         ->where('status', 1)
        //                         ->where('agent_id', $agent->id)
        //                         ->orderBy('created_at', 'DESC') // Ordena por fecha de admisión de forma descendente
        //                         ->with('action') // Carga la relación con actions (si está definida en el modelo)
        //                         ->get();

        // }
    }

    public function saveRetiro($data) {
        $agent = $this->agentRepository->findAgentByCode($data->dni);
        // $agent = Agent::where('dni', $request->dni)
        //                 ->orWhere('code', $request->dni)
        //                 ->first();
        DB::beginTransaction();
        try {
            $sale = $this->salesRepository->saveSale($data);
            // $sale = new Sales();
            // $sale->date_admission = Carbon::now();
            // $sale->amount = -1*($request->amount);
            // $sale->observation = $request->observation;
            // $sale->status = true;
            // $sale->percent = $request->percent;
            // $sale->commission = $request->commission;
            // $sale->exchange_rate = $request->exchange_rate;
            // $sale->agent_id = $agent->id;
            // $sale->action_id = 4;
            // $sale->user_id = Auth::user()->id;
            // if ($sale->save()) {
            //     $resp = 1;
            // }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            //throw $th;
        }

        $bonusAgent = $this->agentBonusRepository->getBonusAgent([1, 2, 3], StatusEnum::ACTIVE->value, 'DESC'); // BonusAgent::where('status', true)->orderBy('date_admission')->get();
    }

    public function filterBonus($data) {
        $dateInit = DateTime::createFromFormat('m/d/Y', $data->dateInit)->format('Y-m-d');
        $dateEnd = DateTime::createFromFormat('m/d/Y', $data->dateEnd)->format('Y-m-d');
        $codigo = $data->code;
        $nombre = $data->code;

        $bonusAgent = $this->salesRepository->searchBonusAgent();
                
    }
}