<?php
namespace App\Services;

use App\Helpers\ResponseHelper;
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

class DepositService
{

    protected $agentRepository;
    protected $transactionTypeRepository;
    protected $depositRepository;
    protected $salesRepository;
    protected $clientRepository;
    protected $userRepository;

    public function __construct(
        AgentRepositoryInterface $agentRepository,
        TransactionTypeRepositoryInterface $transactionTypeRepository,
        DepositRepositoryInterface $depositRepository,
        SalesRepositoryInterface $salesRepository,
        ClientRepositoryInterface $clientRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->agentRepository = $agentRepository;
        $this->transactionTypeRepository = $transactionTypeRepository;
        $this->depositRepository = $depositRepository;
        $this->salesRepository = $salesRepository;
        $this->clientRepository = $clientRepository;
        $this->userRepository = $userRepository;
    }

    public function getAllDeposits()
    {
        try {
            $user = $this->userRepository->getCurrentUser();
            $agent = $this->agentRepository->getMyAgent();
            $transactionsType = $this->transactionTypeRepository->getTransactionTypes();
            $deposits = $this->depositRepository->getAllWithRelations();

            $deposits->transform(function ($deposit) {
                $deposit->date = Carbon::parse($deposit->date)->format('d/m/Y');
                return $deposit;
            });

            $sales = $this->salesRepository->getSales();

            return ResponseHelper::success('Lista de depósitos obtenida correctamente.', [
                'user' => $user,
                'agent' => $agent,
                'transactionsType' => $transactionsType,
                'deposits' => $deposits,
                'sales' => $sales
            ]);
        } catch (Exception $e) {
            Log::error("Error en getAllDeposits: " . $e->getMessage());
            return ResponseHelper::error('Error al obtener la lista de depósitos.');
        }
    }

    public function saveDeposit(array $data)
    {
        DB::beginTransaction();
        try {
            $client = $this->clientRepository->getClientByCode($data['codeClient']);
            $agent = $this->agentRepository->getByCode($data['codeAgent']);
            $user = $this->userRepository->getCurrentUser();

            if (!$client) {
                return ResponseHelper::error("El cliente con código '{$data['codeClient']}' no existe.");
            }
            if (!$agent) {
                return ResponseHelper::error("El agente con código '{$data['codeAgent']}' no existe.");
            }

            $deposit = $this->depositRepository->save([
                'agent_id' => $agent->id,
                'customer_id' => $client->id,
                'date' => Carbon::now(),
                'number' => $data['codeReceipt'],
                'tipo' => "DEPOSITO",
                'descripcion' => $data['description'],
                'amount' => $data['amount'],
                'currency_id' => $data['currency_id'],
                'transaction_type_id' => $data['transaction_type_id'],
                'users_id' => $user->id
            ]);

            DB::commit();

            $deposits = $this->depositRepository->getAllWithRelations();
            $deposits->transform(function ($deposit) {
                $deposit->date = Carbon::parse($deposit->date)->format('d/m/Y');
                return $deposit;
            });

            return ResponseHelper::success('Depósito guardado correctamente.', ['deposits' => $deposits]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en saveDeposit: " . $e->getMessage());
            return ResponseHelper::error('Error al guardar el depósito.');
        }
    }

    public function getDepositData()
    {
        try {
            $user_id = $this->userRepository->getMyUserId();
            $agent = $this->agentRepository->getByUserId($user_id);
            $client = $this->clientRepository->getClientByUserId($user_id);

            return ResponseHelper::success('Datos de depósito obtenidos correctamente.', [
                'agent' => $agent,
                'client' => $client
            ]);
        } catch (Exception $e) {
            Log::error("Error en getDepositData: " . $e->getMessage());
            return ResponseHelper::error('Error al obtener los datos del depósito.');
        }
    }
}