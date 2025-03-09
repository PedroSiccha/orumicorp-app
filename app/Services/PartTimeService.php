<?php
namespace App\Services;

use App\Enums\AssistanceType;
use App\Enums\StatusEnum;
use App\Helpers\ResponseHelper;
use App\Http\Requests\AssistanceRequest;
use App\Http\Requests\PartTimeRequest;
use App\Http\Requests\StoreAssistanceRequest;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\AreaRepositoryInterface;
use App\Interfaces\AssistanceRepositoryInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\PartTimeRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PartTimeService
{

    protected $partTimeRepository, $userRepository, $agentRepository, $clientRepository, $assistanceRepository, $areaRepository;

    public function __construct(
        PartTimeRepositoryInterface $partTimeRepository,
        UserRepositoryInterface $userRepository,
        AgentRepositoryInterface $agentRepository,
        ClientRepositoryInterface $clientRepository,
        AssistanceRepositoryInterface $assistanceRepository,
        AreaRepositoryInterface $areaRepository
    ) {
      $this->partTimeRepository = $partTimeRepository;  
      $this->userRepository = $userRepository;
      $this->agentRepository = $agentRepository;
      $this->clientRepository = $clientRepository;
      $this->assistanceRepository = $assistanceRepository;
      $this->areaRepository = $areaRepository;
    }

    public function getPartTimeData()
    {
        try {
            $user = $this->userRepository->getUser();
            $agent = $this->agentRepository->getAgentByUserId($user->id);
            $client = $this->clientRepository->getClientByUserId($user->id);
            $dateIn = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::INGRESO, $agent->id);
            $dateBreakIn = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::INGRESO_BREAK, $agent->id);
            $dateBreakOut = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::VUELTA_BREAK, $agent->id);
            $dateOut = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::SALIDA, $agent->id);

            $assistances = $this->assistanceRepository->getReportAssistanceByAgent($agent);
            
            $rouletteSpin = $agent->number_turns ?: 0;
            $areas = $this->areaRepository->getAreas();

            $currentDate = Carbon::now()->toDateString();

            $assistances = $this->assistanceRepository->getReportAssistanceNow($currentDate);
            

            $formattedData = [];
            $types = [AssistanceType::INGRESO->value, AssistanceType::INGRESO_BREAK->value, AssistanceType::VUELTA_BREAK->value, AssistanceType::SALIDA->value];

            foreach ($assistances as $record) {
                $date = Carbon::parse($record->date)->format('d/m/Y');
                $agentName = $record->agent_name . " " . $record->last_name;
                $area = $record->area_name;
                $type = $record->type;
            
                $types[$type] = true;
            
                $formattedData[$date][$agentName]['area'] = $area;
                $formattedData[$date][$agentName][$type][] = [
                    'hour' => $record->hour,
                    'observation' => $record->observation
                ];
            }
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $formattedData]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function registerAssistance($request)
    {
        try {
            $agent = $this->agentRepository->getMyAgent();
            $dataAssistance = new StoreAssistanceRequest([
                'hour' => $request->hour,
                'date' => $request->date,
                'date_end' => $request->dateEnd,
                'type' => $request->type,
                'observation' => $request->observation,
                'agent_id' => $agent->id
            ]);
            $assistance = $this->assistanceRepository->saveAssistance($dataAssistance);
            $dateIn = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::INGRESO, $agent->id);
            $dateBreakIn = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::INGRESO_BREAK, $agent->id);
            $dateBreakOut = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::VUELTA_BREAK, $agent->id);
            $dateOut = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::SALIDA, $agent->id);
            $assistances = $this->assistanceRepository->getReportAssistanceByAgent($agent);
            $currentDate = Carbon::now()->toDateString();
            $assistances = $this->assistanceRepository->getReportAssistanceNow($currentDate);
            $formattedData = [];
            $types = [AssistanceType::INGRESO->value, AssistanceType::INGRESO_BREAK->value, AssistanceType::VUELTA_BREAK->value, AssistanceType::SALIDA->value];
            foreach ($assistances as $record) {
                $date = Carbon::parse($record->date)->format('d/m/Y');
                $agentName = $record->agent_name . " " . $record->last_name;
                $area = $record->area_name;
                $type = $record->type;
            
                $types[$type] = true;
            
                $formattedData[$date][$agentName]['area'] = $area;
                $formattedData[$date][$agentName][$type][] = [
                    'hour' => $record->hour,
                    'observation' => $record->observation
                ];
            }
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $formattedData]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function filterAssistance(AssistanceRequest $request)
    {
        try {
            $nombre = $request->code;
            $area = $request->area;
            $user = $this->userRepository->getUser();
            $agent = $this->agentRepository->getMyAgent();
            $startDate = $request->dateInit;
            $endDate = $request->dateEnd;

            if ($startDate) {
                $startDate = Carbon::createFromFormat('m/d/Y', $startDate)->format('Y-m-d');
            } else {
                $startDate = Carbon::now()->toDateString();
            }

            if ($endDate) {
                $endDate = Carbon::createFromFormat('m/d/Y', $endDate)->format('Y-m-d');
            } else {
                $endDate = Carbon::now()->toDateString();
            }

            $assistances = $this->assistanceRepository->searchAssistance($startDate, $endDate, $nombre, $area);
            
            $formattedData = [];
            $types = [AssistanceType::INGRESO->value, AssistanceType::INGRESO_BREAK->value, AssistanceType::VUELTA_BREAK->value, AssistanceType::SALIDA->value];

            foreach ($assistances as $record) {
                $date = Carbon::parse($record->date)->format('d/m/Y');
                $agentName = $record->agent_name . " " . $record->last_name;
                $area = $record->area_name;
                $type = $record->type;
                $formattedData[$date][$agentName]['area'] = $area;
                $formattedData[$date][$agentName][$type][] = [
                    'hour' => $record->hour,
                    'observation' => $record->observation
                ];
            }
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $formattedData]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function registerVacations($request)
    {
        try {
            $user = $this->userRepository->getUser();
            $agent = $this->agentRepository->getMyAgent();
            $dataAssistance = new StoreAssistanceRequest([
                'hour' => $request->hour,
                'date' => $request->dateInitVacations,
                'date_end' => $request->dateEndVacations,
                'type' => AssistanceType::VACATION->value,
                'observation' => $request->observation,
                'agent_id' => $agent->id
            ]);
            $assistance = $this->assistanceRepository->saveAssistance($request);
            $dateIn = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::INGRESO, $agent->id);
            $dateBreakIn = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::INGRESO_BREAK, $agent->id);
            $dateBreakOut = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::VUELTA_BREAK, $agent->id);
            $dateOut = $this->assistanceRepository->findAssistanceDateByTypeAgent(date('Y-m-d'), AssistanceType::SALIDA, $agent->id);
            $currentDate = Carbon::now()->toDateString();
            $assistances = $this->assistanceRepository->getReportAssistanceNow($currentDate);
            $formattedData = [];
            $types = [AssistanceType::INGRESO->value, AssistanceType::INGRESO_BREAK->value, AssistanceType::VUELTA_BREAK->value, AssistanceType::SALIDA->value];
            foreach ($assistances as $record) {
                $date = Carbon::parse($record->date)->format('d/m/Y');
                $agentName = $record->agent_name . " " . $record->last_name;
                $area = $record->area_name;
                $type = $record->type;
                $types[$type] = true;
                $formattedData[$date][$agentName]['area'] = $area;
                $formattedData[$date][$agentName][$type][] = [
                    'hour' => $record->hour,
                    'observation' => $record->observation
                ];
            }
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $formattedData]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }
}