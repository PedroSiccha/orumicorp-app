<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Interfaces\TargetRepositoryInterface;
use App\Models\Target;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class TargetRepository implements TargetRepositoryInterface
{
    public function getTargets(): Collection
    {
        try {
            return Target::where('status', StatusEnum::ACTIVE->value)
                         ->whereMonth('created_at', now()->month)
                         ->orderBy('created_at', 'desc')
                         ->get();
        } catch (QueryException $e) {
            Log::error("Error en TargetRepository@getTargets: " . $e->getMessage());
            throw new Exception("Error al obtener los objetivos.");
        }
    }

    public function saveTarget(array $data): Target
    {
        try {
            return Target::create($data);
        } catch (QueryException $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            throw new Exception("Error al guardar el objetivo.");
        }
    }

    public function getTargetByMonthAndAgent(string $month, int $agentId): ?Target
    {
        try {
            return Target::where('status', StatusEnum::ACTIVE->value)
                ->where('month', $month)
                ->where('agent_id', $agentId)
                ->orderBy('created_at', 'asc')
                ->first();
        } catch (QueryException $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            throw new Exception("Error al buscar objetivo para agente.");
        }
    }

    public function getTargetsWithMonthName(): Collection
    {
        try {
            return Target::select('id', 'amount', 'agent_id')
                         ->selectRaw("MONTHNAME(CONCAT('2024-', month, '-01')) AS mes")
                         ->get();
        } catch (QueryException $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            throw new Exception("Error al obtener los objetivos por mes.");
        }
    }

    public function updateTarget(Target $target, array $data): bool
    {
        try {
            return $target->update($data);
        } catch (QueryException $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            return false;
        }
    }

    public function incrementTargetAmount(Target $target, float $amount): bool
    {
        try {
            $target->amount += $amount;
            return $target->save();
        } catch (QueryException $e) {
            Log::error("Error al incrementar monto del objetivo: " . $e->getMessage());
            return false;
        }
    }

    public function getPaginatedTargetsByAgent(int $agentId, int $pagination): LengthAwarePaginator
    {
        try {
            return Target::select('id', 'amount', 'agent_id')
                ->selectRaw("MONTHNAME(CONCAT('2024-', month, '-01')) AS mes")
                ->where('agent_id', $agentId)
                ->paginate($pagination, ['*'], 'targets_page')
                ->withQueryString();
        } catch (QueryException $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            throw new Exception("Error al obtener objetivos paginados por agente.");
        }
    }

    public function findTargetById(int $targetId): ?Target
    {
        try {
            return Target::find($targetId);
        } catch (QueryException $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            throw new Exception("Error al obtener el objetivo por ID.");
        }
    }
}
