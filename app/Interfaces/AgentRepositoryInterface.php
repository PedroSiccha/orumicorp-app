<?php
namespace App\Interfaces;

use App\Models\Agent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface AgentRepositoryInterface
{
    public function getById(int $agentId): ?Agent;
    public function getByCode(string $code): ?Agent;
    public function getByUserId(int $userId): ?Agent;
    public function allActive(): Collection;
    public function paginate(int $perPage = 10): LengthAwarePaginator;
    public function save(array $data): Agent;
    public function update(Agent $agent, array $data): bool;
    public function delete(int $agentId): bool;
    public function changeStatus(int $agentId, bool $status): bool;
    public function filter(array $filters, int $limit = 10): LengthAwarePaginator;
    public function saveAgentImage(int $agentId, string $url): bool;
    public function updateTurns(int $agentId, int $turns): bool;
    public function getMyAgent(): ?Agent;
    public function findAgentByArea(int $areaId): ?Agent;
}
