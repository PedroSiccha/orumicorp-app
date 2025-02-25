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

    public function findByCodeOrVoiso(string $code): ?Agent
    {
        try {
            return Agent::where('code_voiso', $code)
                    ->orWhere('code', $code)
                    ->first();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener el agente: " . $e->getMessage());
        }
    }

    public function getAllAgentsPaginated(int $perPage)
    {
        try {
            return Agent::orderBy('lastname')->paginate($perPage);
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener los agentes: " . $e->getMessage());
        }
    }

    public function findAgentByCode(string $code): ?Agent
    {
        try {
            return Agent::where('code_voiso', $code)->orWhere('code', $code)->first();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener los agentes: " . $e->getMessage());
        }
    }

    public function saveAgent(array $data): ?Agent
    {
        try {
            return Agent::create($data);
        } catch (Exception $e) {
            throw new RepositoryException("Error al guardar el agente: " . $e->getMessage());
        }
    }

}
