<?php
namespace App\Services;

use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\DepositRepositoryInterface;
use App\Interfaces\SalesRepositoryInterface;
use App\Interfaces\TransactionTypeRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DepositService
{

    protected $agentRepository;
    protected $transactionTypeService;
    protected $depositRepository;
    protected $salesRepository;
    protected $clientRepository;
    protected $userRepository;

    public function __construct(
        AgentRepositoryInterface $agentRepository,
        TransactionTypeRepositoryInterface $transactionTypeService,
        DepositRepositoryInterface $depositRepository,
        SalesRepositoryInterface $salesRepository,
        ClientRepositoryInterface $clientRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->agentRepository = $agentRepository;
        $this->transactionTypeService = $transactionTypeService;
        $this->depositRepository = $depositRepository;
        $this->salesRepository = $salesRepository;
        $this->clientRepository = $clientRepository;
        $this->userRepository = $userRepository;
    }

    public function getDataDeposits() {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        $roles = $user->getRoleNames()->first();
        $agent = $this->agentRepository->getAgentByUserId($user->id); // Agent::where('user_id', $user_id)->first();

        $rouletteSpin = $agent->number_turns ?: 0;
        $transactionsType = $this->transactionTypeService->getTransactionTypes();
        $deposits = $this->depositRepository->getDeposits();
        foreach ($deposits as &$deposit) {
            if (isset($deposit['date'])) {
                $deposit['date'] = Carbon::parse($deposit['date'])->format('d/m/Y');
            }

        }
        $sales = $this->salesRepository->getSales();
    }

    public function saveDeposit($request)
    {
        
        $client = $this->clientRepository->getClientByCode($request->codeClient);
        $agent = $this->agentRepository->getAgentByCode($request->codeAgent);
        // Agent::where('code_voiso', $request->codeAgent)
        //               ->orWhere('code', $request->codeAgent)
        //               ->first();

        $user_id = $this->userRepository->getMyId();

        DB::beginTransaction();
        try {
            $deposit = $this->depositRepository->saveDeposit($request);
            DB::commit();
            // $deposit = new Deposit();
            // $deposit->agent_id = $agent->id;
            // $deposit->customer_id = $client->id;
            // $deposit->date = Carbon::now();
            // $deposit->number = $request->codeReceipt;
            // $deposit->tipo = "DEPOSITO";
            // $deposit->descripcion = "";
            // $deposit->amount = $request->amount;
            // $deposit->transaction_type_id = $request->transaction_type_id;
            // $deposit->users_id = $user_id;

            // if ($deposit->save()) {
            //     $title = "Correcto";
            //     $mensaje = "Su depósito se registró correctamente";
            //     $status = "success";
            // }

        } catch (ValidationException $e) {
            DB::rollBack();
            // $title = "Error";
            // $mensaje = $e->getMessage();
            // $status = "error";
        } catch (Exception $e) {
            DB::rollBack();
            // $title = "Error";
            // $mensaje = $e->getMessage();
            // $status = "error";
        }

        $deposits = $this->depositRepository->getDeposits();
        foreach ($deposits as &$deposit) {
            if (isset($deposit['date'])) {
                $deposit['date'] = Carbon::parse($deposit['date'])->format('d/m/Y');
            }

        }
    }

    public function getDepositData()
    {
        $user_id = $this->userRepository->getMyId();

        $agent = $this->agentRepository->getAgentByUserId($user_id); // $agent = Agent::where('user_id', $user_id)->first();
        $client = $this->clientRepository->getClientByUserId($user_id); // $client = Customers::where('user_id', $user_id)->first();
        $rouletteSpin = $agent->number_turns ?: 0;

        // $dataUser = null;

        // if ($agent) {
        //     $dataUser = $agent;
        // }

        // if ($client) {
        //     $dataUser = $client;
        // }

        // $premios = Premio::where('status', true)->get();
        // $premios1 = Premio::where('status', true)->where('type', 1)->get();
        // $premios2 = Premio::where('status', true)->where('type', 2)->get();
        // return view('gestionRuleta.index', compact('premios', 'premios1', 'premios2', 'dataUser', 'rouletteSpin'));
    }
}