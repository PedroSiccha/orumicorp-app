<?php
namespace App\Interfaces;

use App\Models\Agent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface AgentRepositoryInterface
{
    public function getAgentByUserId(int $userId): ?Agent;
    public function getAllAgents(): Collection;
    public function findByCodeOrVoiso(string $code): ?Agent;
    public function getAllAgentsPaginated(int $perPage);
    public function findAgentByCode(string $code): ?Agent;
    public function saveAgent(array $data): ?Agent;
    public function updateAgent(array $data): ?Agent;

}
