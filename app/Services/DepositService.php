<?php
namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreDepositRequest;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\DepositRepositoryInterface;
use App\Interfaces\SalesRepositoryInterface;
use App\Interfaces\TransactionTypeRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    public function getDataDeposits() 
    {
        $user = $this->userRepository->getUser();
        $roles = $user->getRoleNames()->first();
        $agent = $this->agentRepository->getMyAgent();
        $rouletteSpin = $agent->number_turns ?: 0;
        $transactionsType = $this->transactionTypeService->getTransactionTypes();
        $deposits = $this->depositRepository->getDeposits();
        foreach ($deposits as &$deposit) {
            if (isset($deposit['date'])) {
                $deposit['date'] = Carbon::parse($deposit['date'])->format('d/m/Y');
            }
        }
        $sales = $this->salesRepository->getSales();
        return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $sales]);
    }

    public function saveDeposit($request)
    {
        $client = $this->clientRepository->getClientByCode($request->codeClient);
        $agent = $this->agentRepository->findAgentByCode($request->codeAgent);
        $user = $this->userRepository->getUser();
        DB::beginTransaction();
        try {
            $dataDeposit = new StoreDepositRequest([
                'agent_id' => $agent->id,
                'customer_id' => $client->id,
                'date' => Carbon::now(),
                'number' => $request->codeReceipt,
                'tipo' => "DEPOSITO",
                'descripcion' => $request->description,
                'amount' => $request->amount,
                'currency_id' => $request->currency_id,
                'transaction_type_id' => $request->transaction_type_id,
                'users_id' => $user->id
            ]);
            $deposit = $this->depositRepository->saveDeposit($dataDeposit);
            DB::commit();
            $deposits = $this->depositRepository->getDeposits();
            foreach ($deposits as &$deposit) {
                if (isset($deposit['date'])) {
                    $deposit['date'] = Carbon::parse($deposit['date'])->format('d/m/Y');
                }
            }
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $deposits]);
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

    public function getDepositData()
    {
        $user_id = $this->userRepository->getMyId();
        $agent = $this->agentRepository->getAgentByUserId($user_id);
        $client = $this->clientRepository->getClientByUserId($user_id);
        $rouletteSpin = $agent->number_turns ?: 0;
        return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $agent]);
    }
}