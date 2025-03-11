<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Interfaces\AwardRepositoryInterface;
use App\Models\Premio;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

class AwardRepository implements AwardRepositoryInterface
{
    public function getAwardsByType(int $awardType): Collection
    {
        try {
            $awards = Premio::where('status', StatusEnum::ACTIVE->value)
                            ->where('type', $awardType)
                            ->get();

            if ($awards->isEmpty()) {
                Log::warning("No se encontraron premios del tipo: {$awardType}");
            }

            return $awards;
        } catch (Throwable $e) {
            Log::error("Error en AwardRepository - getAwardsByType: " . $e->getMessage());
            throw new Exception("Error al obtener premios del tipo: {$awardType}");
        }
    }

    public function findAwardByOrder(string $orderNumber): ?Premio
    {
        try {
            $award = Premio::where('order', $orderNumber)->first();
            if (!$award) {
                Log::warning("No se encontró un premio con el número de orden: {$orderNumber}");
                return null;
            }
            return $award;
        } catch (Throwable $e) {
            Log::error("Error en AwardRepository - findAwardByOrder: " . $e->getMessage());
            throw new Exception("Error al buscar el premio por número de orden.");
        }
    }

}
