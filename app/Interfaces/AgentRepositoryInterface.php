<?php
namespace App\Interfaces;

use App\Models\Agent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface AgentRepositoryInterface
{
    public function getAgentByUserId(int $userId): ?Agent;
    public function getAllAgents(): Collection;
}
