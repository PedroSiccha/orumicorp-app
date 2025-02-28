<?php
namespace App\Interfaces;

use App\Models\Agent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface AgentRepositoryInterface
{
    public function getAgentByUserId(int $userId): ?Agent;
    public function getAllAgents(): Collection;
    public function getAllAgentsPaginated(int $perPage);
    public function getAgents(): Collection;
    public function getAgentByCode(string $agentCode): ?Agent;

    public function findByCodeOrVoiso(string $code): ?Agent;
    public function findAgentById(int $agentId): ? Agent;
    public function findAgentByCode(string $code): ?Agent;
    public function filterAgent(FilterAgentRequest $data): Collection;

    public function saveAgent(array $data): ?Agent;
    public function saveNumberTurns(Agent $agent, int $quantity): Agent;
    public function saveAgentImage(Agent $agent, string $url): Agent;

    public function changeAgentStatus(Agent $agent, bool $status): Agent;

    public function updateAgent(Agent $agent, array $data): ?Agent;

    public function deleteAgent(int $agentId): bool;
}
