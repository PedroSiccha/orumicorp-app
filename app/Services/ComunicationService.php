<?php
namespace App\Services;

use App\Enums\StatusEnum;
use App\Helpers\ResponseHelper;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\ClientStatusRepositoryInterface;
use App\Interfaces\ComunicationRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

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

    public function saveComunication(array $data)
    {
        DB::beginTransaction();
        try {
            $agent = $this->agentRepository->getMyAgent();

            if (!$agent) {
                return ResponseHelper::error("No se encontró el agente asociado.");
            }

            $data['agent_id'] = $agent->id;
            $data['date'] = Carbon::now();
            $data['tipo'] = 'Llamada';
            $data['status'] = StatusEnum::NUEVO->value;

            $comunication = $this->comunicationRepository->save($data);
            DB::commit();

            return ResponseHelper::success("Comunicación guardada correctamente.", ['comunication' => $comunication]);
        } catch (Throwable $e) { 
            DB::rollBack();
            Log::error("Error inesperado en updateComunication: " . $e->getMessage());
            return ResponseHelper::error("Ocurrió un error inesperado. Contacte con soporte.");
        }        
    }

    public function updateComunication(array $data)
    {
        DB::beginTransaction();
        try {
            $customerStatus = $this->customerStatusRepository->findById($data['customerStatusId']);
            $statusCommunicationName = $customerStatus ? $customerStatus->name : null;

            $comunication = $this->comunicationRepository->findById($data['comunicationId']);

            if (!$comunication) {
                return ResponseHelper::error("Comunicación no encontrada.");
            }

            $data['status'] = $statusCommunicationName;

            $updated = $this->comunicationRepository->update($comunication, $data);
            DB::commit();

            return ResponseHelper::success("Comunicación actualizada correctamente.", ['comunication' => $updated]);
        } catch (Throwable $e) { 
            DB::rollBack();
            Log::error("Error inesperado en updateComunication: " . $e->getMessage());
            return ResponseHelper::error("Ocurrió un error inesperado. Contacte con soporte.");
        }        
    }

    public function getLocationByAgent(int $agentId)
    {
        try {
            $communications = $this->comunicationRepository->getComunicationsByAgent($agentId);
            return ResponseHelper::success("Historial de comunicaciones del agente obtenido correctamente.", ['communications' => $communications]);
        } catch (Exception $e) {
            Log::error("Error en getLocationByAgent: " . $e->getMessage());
            return ResponseHelper::error("Error al obtener el historial de comunicaciones del agente.");
        }
    }

    public function getLocationByCustomer(int $customerId)
    {
        try {
            $communications = $this->comunicationRepository->getComunicationsByCustomer($customerId);
            return ResponseHelper::success("Historial de comunicaciones del cliente obtenido correctamente.", ['communications' => $communications]);
        } catch (Exception $e) {
            Log::error("Error en getLocationByCustomer: " . $e->getMessage());
            return ResponseHelper::error("Error al obtener el historial de comunicaciones del cliente.");
        }
    }

}
