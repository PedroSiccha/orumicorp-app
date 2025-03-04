<?php
namespace App\Interfaces;

use App\Http\Requests\EditAgentRequest;
use App\Http\Requests\FilterAgentRequest;
use App\Http\Requests\StoreAgentRequest;
use App\Models\Agent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface AgentRepositoryInterface
{
    public function getAgentByUserId(int $userId): ?Agent;
    public function getAllAgents(): Collection;
    public function getAllAgentsPaginated(int $perPage): LengthAwarePaginator;
    public function getAgents(): Collection;

    public function findAgentById(int $agentId): ? Agent;
    public function findAgentByCode(string $code): ?Agent;
    public function findAgentByArea(int $areaId): ?Agent;
    public function filterAgent(FilterAgentRequest $data, int $limit = 10): LengthAwarePaginator;

    public function saveAgent(StoreAgentRequest $data): ?Agent;
    public function saveNumberTurns(Agent $agent, int $quantity): bool;
    public function saveAgentImage(Agent $agent, string $url): bool;

    public function changeAgentStatus(Agent $agent, bool $status): bool;

    public function updateAgent(Agent $agent, EditAgentRequest $data): bool;

    public function deleteAgent(int $agentId): bool;
}
