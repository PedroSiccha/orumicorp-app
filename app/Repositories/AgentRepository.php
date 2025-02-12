<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Interfaces\AgentRepositoryInterface;
use App\Models\Agent;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class AgentRepository implements AgentRepositoryInterface
{

    public function getAgentByUserId(int $userId): ?Agent
    {
        try {
            return Agent::where('user_id', $userId)->first();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener el agente del usuario ID {$userId}: " . $e->getMessage());
        }

    }

    public function getAllAgents(): Collection
    {
        try {
            return Agent::all();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener los agentes: " . $e->getMessage());
        }
    }

}
