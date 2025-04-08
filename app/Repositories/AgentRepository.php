<?php
namespace App\Repositories;

use App\Contracts\Repositories\AgentRepositoryInterface;
use App\Enums\StatusEnum;
use App\Models\Agent;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class AgentRepository implements AgentRepositoryInterface
{
    public function getById(int $agentId): ?Agent
    {
        return Agent::find($agentId);
    }

    public function getByCode(string $code): ?Agent
    {
        return Agent::where('code', $code)->first();
    }

    public function getByUserId(int $userId): ?Agent
    {
        return Agent::where('user_id', $userId)->first();
    }

    public function allActive(): Collection
    {
        return Agent::where('status', StatusEnum::ACTIVE->value)->get();
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Agent::orderBy('id', 'desc')->paginate($perPage);
    }

    public function save(array $data): Agent
    {
        try {
            return Agent::create($data);
        } catch (QueryException $e) {
            Log::error('AgentRepository@save: ' . $e->getMessage());
            throw new Exception('Error al crear el agente.');
        }
    }

    public function update(Agent $agent, array $data): bool
    {
        try {
            return $agent->update($data);
        } catch (QueryException $e) {
            Log::error('AgentRepository@update: ' . $e->getMessage());
            throw new Exception('Error al actualizar agente.');
        }
    }

    public function delete(int $agentId): bool
    {
        try {
            $agent = Agent::findOrFail($agentId);
            return $agent->delete();
        } catch (QueryException $e) {
            Log::error('AgentRepository@delete: ' . $e->getMessage());
            throw new Exception('Error al eliminar agente.');
        }
    }

    public function changeStatus(int $agentId, bool $status): bool
    {
        try {
            $agent = Agent::findOrFail($agentId);
            $agent->status = $status;
            return $agent->save();
        } catch (QueryException $e) {
            Log::error('AgentRepository@changeStatus: ' . $e->getMessage());
            throw new Exception('Error al cambiar el estado del agente.');
        }
    }

    public function filter(array $filters, int $limit = 10): LengthAwarePaginator
    {
        $query = Agent::query();

        if (!empty($filters['code'])) {
            $query->where('code', 'LIKE', "%{$filters['code']}%");
        }

        if (!empty($filters['area_id'])) {
            $query->where('area_id', $filters['area_id']);
        }

        return $query->paginate($limit);
    }

    public function saveAgentImage(int $agentId, string $url): bool
    {
        try {
            $agent = Agent::findOrFail($agentId);
            $agent->image_url = $url;
            return $agent->save();
        } catch (QueryException $e) {
            Log::error('AgentRepository@saveAgentImage: ' . $e->getMessage());
            return false;
        }
    }

    public function updateTurns(int $agentId, int $turns): bool
    {
        try {
            $agent = Agent::findOrFail($agentId);
            $agent->number_turns = $turns;
            return $agent->save();
        } catch (QueryException $e) {
            Log::error('AgentRepository@updateTurns: ' . $e->getMessage());
            return false;
        }
    }

    public function getMyAgent(): ?Agent
    {
        try {
            $user = Auth::user();
            if (!$user) {
                throw new Exception("Usuario no autenticado.");
            }
            return Agent::where('user_id', $user->id)->first();
        } catch (Throwable $e) {
            Log::error("Error en getMyAgent (AgentRepository): " . $e->getMessage());
            throw new Exception("No se pudo obtener el agente.");
        }
    }

    public function findAgentByArea(int $areaId): ?Agent
    {
        try {
            $agent = Agent::where('area_id', $areaId)
                        ->where('status', StatusEnum::ACTIVE->value)
                        ->first();
            if (!$agent) {
                Log::warning("No se encontró un agente en la zona con ID: {$areaId}. Verifica si hay agentes asignados en esta área.");
                return null;
            }
            return $agent;
        } catch (Throwable $e) {
            Log::error("Error en findAgentByArea (AgentRepository) para el área ID: {$areaId} - " . $e->getMessage());
            throw new Exception("Error al buscar un agente en la zona especificada.");
        }
    }
}
