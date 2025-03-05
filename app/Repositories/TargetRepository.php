<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Http\Requests\EditTargetRequest;
use App\Http\Requests\StoreTargetRequest;
use App\Interfaces\TargetRepositoryInterface;
use App\Models\Agent;
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
                            ->where('month', date("m"))
                            ->orderBy("created_at", "asc")
                            ->get();
        } catch (QueryException $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveTarget(StoreTargetRequest $data): ?Target
    {
        try {
            return Target::create($data);
        } catch (QueryException $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getTargetByMonthAgent(string $month, Agent $agent): ?Target
    {
        try {
            return Target::where('status', StatusEnum::ACTIVE->value)
                        ->where('month', $month)
                        ->where('agent_id', $agent->id)
                        ->orderBy("created_at", "asc")
                        ->first();
        } catch (QueryException $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getTargetWithDate(): Collection
    {
        try {
            return Target::select('id', 'amount', 'agent_id')
                        ->selectRaw("MONTHNAME(CONCAT('2024-', month, '-01')) AS mes")
                        ->get();
        } catch (QueryException $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function updateTarget(Target $target, EditTargetRequest $data): bool
    {
        try {
            $target->fill($data->validated());
            if (!$target->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            return false;
        }
    }

    public function updateAmountTarget(Target $target, float $amount): bool
    {
        try {
            $newAmount = $target->amount + $amount;
            $target->amount = $newAmount;
            if (!$target->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            return false;
        }
    }

    public function getTargetsByAgent(int $agentId, int $pagination): LengthAwarePaginator
    {
        try {
            return Target::select('id', 'amount', 'agent_id')
                        ->selectRaw("MONTHNAME(CONCAT('2024-', month, '-01')) AS mes")
                        ->where('agent_id', $agentId)
                        ->paginate($pagination, ['*'], 'targets_page')->withQueryString();
        } catch (QueryException $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error TargetRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }
}
