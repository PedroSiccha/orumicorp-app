<?php
namespace App\Interfaces;

use App\Http\Requests\StoreBonusAgentRequest;
use App\Models\Area;
use App\Models\BonusAgent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface AgentBonusRepositoryInterface
{
    public function getBonusAgent(array $actions, bool $status, string $order): Collection;
    public function saveBonus(StoreBonusAgentRequest $request): BonusAgent;
}
 