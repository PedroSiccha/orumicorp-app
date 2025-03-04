<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Interfaces\AwardRepositoryInterface;
use App\Models\Premio;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class AwardRepository implements AwardRepositoryInterface
{
    public function getAwardsByType(int $type): Collection
    {
        try {
            return Premio::where('status', StatusEnum::ACTIVE->value)->where('type', $type)->get();
        } catch (QueryException $e) {
            Log::error("Error AwardRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AwardRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function findAwardByName(string $data): Collection
    {
        try {
            return Premio::where('order', $data)->first();
        } catch (QueryException $e) {
            Log::error("Error AwardRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AwardRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }
}
