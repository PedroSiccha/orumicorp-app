<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Interfaces\PriorityRepositoryInterface;
use App\Models\Priority;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class PriorityRepository implements PriorityRepositoryInterface
{
    public function getAllPriorities(): Collection
    {
        try {
            return Priority::all();
        } catch (QueryException $e) {
            Log::error("Error PriorityRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error PriorityRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getPriorities(): Collection
    {
        try {
            return Priority::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error("Error PriorityRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error PriorityRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function findPriorityById(int $priorityId): ?Priority
    {
        try {
             return Priority::where('id', $priorityId)->where('status', StatusEnum::ACTIVE->value)->first();
        } catch (QueryException $e) {
            Log::error("Error PriorityRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error PriorityRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }
}
