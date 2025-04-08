<?php
namespace App\Contracts\Repositories;

use App\Models\Target;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface TargetRepositoryInterface
{
    public function getTargets(): Collection;
    public function saveTarget(array $data): Target;
    public function getTargetByMonthAndAgent(string $month, int $agentId): ?Target;
    public function getTargetsWithMonthName(): Collection;
    public function updateTarget(Target $target, array $data): bool;
    public function incrementTargetAmount(Target $target, float $amount): bool;
    public function getPaginatedTargetsByAgent(int $agentId, int $pagination): LengthAwarePaginator;
    public function findTargetById(int $targetId): ?Target;
}
