<?php
namespace App\Repositories;

use App\Contracts\Repositories\AgentBonusRepositoryInterface;
use App\Models\BonusAgent;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class AgentBonusRepository implements AgentBonusRepositoryInterface
{
    public function getByAgentId(int $agentId): Collection
    {
        try {
            return BonusAgent::where('agent_id', $agentId)->get();
        } catch (QueryException $e) {
            Log::error('AgentBonusRepository@getByAgentId: ' . $e->getMessage());
            throw new Exception('Error al obtener los bonos del agente.');
        }
    }

    public function save(array $data): BonusAgent
    {
        try {
            return BonusAgent::create($data);
        } catch (QueryException $e) {
            Log::error('AgentBonusRepository@saveBonus: ' . $e->getMessage());
            throw new Exception('Error al guardar bono del agente.');
        }
    }
}
