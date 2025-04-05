<?php
namespace App\Interfaces;

use App\Models\BonusAgent;
use Illuminate\Database\Eloquent\Collection;

interface AgentBonusRepositoryInterface
{
    public function getByAgentId(int $agentId): Collection;
    public function save(array $data): BonusAgent;
}
 