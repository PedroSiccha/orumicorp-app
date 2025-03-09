<?php
namespace App\Interfaces;

use App\Http\Requests\EditTargetRequest;
use App\Http\Requests\StoreTargetRequest;
use App\Models\Agent;
use App\Models\Target;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface TargetRepositoryInterface
{
    public function getTargets(): Collection;
    public function saveTarget(StoreTargetRequest $data): ?Target;
    public function getTargetByMonthAgent(string $month, Agent $agent): ?Target;
    public function getTargetWithDate(): Collection;
    public function updateTarget(Target $target, StoreTargetRequest $data): bool;
    public function updateAmountTarget(Target $target, float $amount): bool;
    public function getTargetsByAgent(int $agentId, int $pagination): LengthAwarePaginator;
    public function findTargetById(int $targetId): ?Target;
}
