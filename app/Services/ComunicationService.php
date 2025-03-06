<?php
namespace App\Services;

use App\Enums\StatusEnum;
use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreComunicationRequest;
use App\Http\Requests\StoreCustomerStatusRequest;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\ClientStatusRepositoryInterface;
use App\Interfaces\ComunicationRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ComunicationService
{

    protected $userRepository, $agentRepository, $comunicationRepository, $customerStatusRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AgentRepositoryInterface $agentRepository,
        ComunicationRepositoryInterface $comunicationRepository, 
        ClientStatusRepositoryInterface $customerStatusRepository
    ) {
        $this->userRepository = $userRepository;
        $this->agentRepository = $agentRepository;
        $this->comunicationRepository = $comunicationRepository;
        $this->customerStatusRepository = $customerStatusRepository;
    }

    public function saveComunication($request) {
        DB::beginTransaction();
        try {
            $agent = $this->agentRepository->getMyAgent();
            $dataComunication = new StoreComunicationRequest([
                'agent_id' => $agent->id,
                'customer_id' => $request['customer_id'],
                'date' => Carbon::now(),
                'tipo' => 'Llamada',
                'descripcion' => $request['description'],
                'comment' => $request['comment'],
                'status' => StatusEnum::NUEVO->value
            ]);

            $comunication = $this->comunicationRepository->saveComunication($dataComunication);
            DB::commit();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $comunication]);
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

    public function updateComunication($request) 
    {
        $statusCommunicationName = "";
        DB::beginTransaction();
        try {
            $customerStatus = $this->customerStatusRepository->findStatusById($request['customerStatusId']);
            if ($customerStatus) {
                $statusCommunicationName = $customerStatus->name;
            }
            $agent = $this->agentRepository->getMyAgent();
            $comunication = $this->comunicationRepository->findComunicationById($request['comunicationId']);
            $dataComunication = new StoreComunicationRequest([
                'comment' => $request['comment'],
                'status' => $statusCommunicationName
            ]);
            $response = $this->comunicationRepository->updateComunication($comunication, $dataComunication);
            DB::commit();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $response]);

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

    public function getLocationByAgent($request) 
    {
        try {
            $communication = $this->comunicationRepository->getComunicationsByAgent($request['agent_id']);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $communication]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function getLocationByCustomer($request) {
        try {
            $communications = $this->comunicationRepository->getComunicationsbyCustomer($request['customer_id']);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $communications]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

}
