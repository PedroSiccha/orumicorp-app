<?php
namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\AreaRepositoryInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\PriorityRepositoryInterface;
use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TaskService
{

    protected $taskRepository, $userRepository, $agentRepository, $areaRepository, $priorityRepository, $clientRepository;

    public function __construct(
        TaskRepositoryInterface $taskRepository,
        UserRepositoryInterface $userRepository,
        AgentRepositoryInterface $agentRepository,
        AreaRepositoryInterface $areaRepository,
        PriorityRepositoryInterface $priorityRepository,
        ClientRepositoryInterface $clientRepository
    ) {
      $this->taskRepository = $taskRepository; 
      $this->userRepository = $userRepository; 
      $this->agentRepository = $agentRepository;
      $this->areaRepository = $areaRepository;
      $this->priorityRepository = $priorityRepository;
      $this->clientRepository = $clientRepository;
    }

    public function getTaskData()
    {
        try {
            $user = $this->userRepository->getCurrentUser();
            $roles = $user->getRoleNames()->first();
            $agent = $this->agentRepository->getById($user->id);
            $areas = $this->areaRepository->getAllActive();
            $priorities = $this->priorityRepository->getAll();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $priorities]);
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function getTask()
    {
        try {
            $eventos = $this->taskRepository->getTasks();
            $eventos_formateados = [];
            foreach ($eventos as $evento) {
                $eventos_formateados[] = [
                    'id' => $evento->id,
                    'title' => $evento->agent->name . " " . $evento->agent->lastname . " - " . $evento->name,
                    'start' => $evento->start,
                    'end' => $evento->end,
                    'backgroundColor' => $evento->priority->color,
                    'borderColor' => $evento->priority->color,
                ];
            }
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $eventos_formateados]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function saveTask($request)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->getCurrentUser();
            $agent = $this->agentRepository->getMyAgent();
            $dataTask = [
                'name' => $request->titulo,
                'description' => $request->descripcion,
                'timeStart' => $request->horaInicio,
                'timeEnd' => $request->horaFin,
                'date' => date("Y-m-d", strtotime($request->fecha)),
                'agent_id' => $agent->id
            ];
            $response = $this->taskRepository->saveTask($dataTask);
            DB::commit();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.');
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

    public function saveEvent($request)
    {
        $agent = $this->agentRepository->getByCode($request->codAgent);
        $priority = $this->priorityRepository->findById( $request->priorityEvent);
        $client = $this->clientRepository->getClientByCode($request->codCustomer);
        DB::beginTransaction();
        try {
            $dataTask = [
                'name' => $request->nameEvent,
                'description' => $request->descriptionEvent,
                'timeStart' => $request->desde,
                'timeEnd' => $request->hasta,
                'date' => $request->dateEvent,
                'agent_id' => $agent->id,
                'priority_id' => $priority->id,
                'customer_id' => $client->id,
                'start' => $request->dateEvent ." ".$request->desde,
                'end' => $request->dateEvent ." ".$request->hasta
            ];
            $response = $this->taskRepository->saveTask($dataTask);
            DB::commit();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.');
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

    public function getEventById(Request $request)
    {
        try {
            $evento = $this->taskRepository->getTasksByCustomer($request->clientId);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $evento]);
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

    public function editEvent($request)
    {
        $user = $this->userRepository->getCurrentUser();
        $agent = $this->agentRepository->getMyAgent();
        $priority = $this->priorityRepository->findById($request->priorityEvent);
        $client = $this->clientRepository->getClientByCode($request->codCustomer);
        $task = $this->taskRepository->findTaskById($request->taskId);
        $dataTask = [
            'name' => $request->nameEvent,
            'description' => $request->descriptionEvent,
            'timeStart' => $request->desde,
            'timeEnd' => $request->hasta,
            'date' => $request->dateEvent,
            'agent_id' => $agent->id,
            'priority_id' => $priority->id,
            'customer_id' => $client->id,
            'start' => $request->dateEvent ." ".$request->desde,
            'end' => $request->dateEvent ." ".$request->hasta,
        ];
        DB::beginTransaction();
        try {
            $response = $this->taskRepository->updateTask($task, $dataTask);
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

    public function deleteEvent($request)
    {
        DB::beginTransaction();
        try {
            $response = $this->taskRepository->deleteTask($request->id);
            DB::commit();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.');
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
}