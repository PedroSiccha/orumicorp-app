<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Http\Requests\EditAgentRequest;
use App\Http\Requests\FilterAgentRequest;
use App\Http\Requests\StoreAgentRequest;
use App\Interfaces\AgentRepositoryInterface;
use App\Models\Agent;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AgentRepository implements AgentRepositoryInterface
{

    public function getMyAgent(): ?Agent
    {
        try {
            $userId = Auth::user()->id;
            return Agent::where('user_id', $userId)->first();
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getAgentByUserId(int $userId): ?Agent
    {
        try {
            return Agent::where('user_id', $userId)->first();
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getAllAgents(): Collection
    { 
        try {
            return Agent::all();
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getAllAgentsPaginated(int $perPage): LengthAwarePaginator
    {
        try {
            return Agent::orderBy('lastname')->paginate($perPage);
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function findAgentByCode(string $code): ?Agent
    {
        try {
            return Agent::where('code_voiso', $code)->orWhere('code', $code)->first();
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveAgent(StoreAgentRequest $data): ?Agent
    {
        try {
            return Agent::create($data);
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getAgents(): Collection
    {
        try {
            return Agent::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function findAgentById(int $agentId): ?Agent
    {
        try {
            return Agent::find($agentId);
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function filterAgent(FilterAgentRequest $data, int $limit = 10): LengthAwarePaginator
    {
        $code = $data->code;
        try {
            return Agent::where('area_id', $data->areaId)->where(
                        function ($query) use ($code) {
                            $query->whereRaw('CONCAT(name, " ", lastname) LIKE ?', ['%'.$code.'%'])
                                ->orWhere('code', 'like', '%'.$code.'%');
                        })->paginate($limit);
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function findAgentByArea(int $areaId): ?Agent
    {
        try {
            return Agent::where('area_id', $areaId)->first();
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveNumberTurns(Agent $agent, int $quantity): bool
    {
        try {
            $agent->number_turns = $quantity;
            if (!$agent->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            return false;
        }
    }

    public function saveAgentImage(Agent $agent, string $url): bool
    {
        try {
            $agent->img = $url;
            if (!$agent->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            return false;
        }
    }

    public function changeAgentStatus(Agent $agent, bool $status): bool
    {
        try {
            $agent->status = $status;
            if (!$agent->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            return false;
        }
    }

    public function updateAgent(Agent $agent, EditAgentRequest $data): bool
    {
        try {
            $agent->fill($data->validated());
            if (!$agent->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            return false;
        }
    }

    public function deleteAgent(int $agentId): bool
    {
        try {
            $agent = Agent::find($agentId);
            if (!$agent) {
                return false;
            }
            if (!$agent->delete()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            return false;
        }
    }

}
