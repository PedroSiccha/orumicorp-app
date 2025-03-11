<?php
namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\ViewsRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ViewsService
{

    protected $viewsRepository;
    protected $userRepository;
    protected $agentRepository;

    public function __construct(
        ViewsRepositoryInterface $viewsRepository,
        UserRepositoryInterface $userRepository,
        AgentRepositoryInterface $agentRepository
    ) {
      $this->viewsRepository = $viewsRepository;
      $this->userRepository = $userRepository;
      $this->agentRepository = $agentRepository;
    }

    public function saveViews($request)
    {
        $user_id = $this->userRepository->getMyUserId();
        $agent = $this->agentRepository->getMyAgent();
        $dataView = [
            'agent_id' => $agent->id,
            'customer_id' => $request->clientId,
            'viewed_at' => Carbon::now()
        ];
        DB::beginTransaction();
        try {
            $view = $this->viewsRepository->saveViews($dataView);
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

    public function getViews(Request $request)
    {
        try {
            $data = $this->viewsRepository->getViewsByClients($request->client_id);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $data]);
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