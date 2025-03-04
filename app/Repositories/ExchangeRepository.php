<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Interfaces\ExchangeRepositoryInrterface;
use App\Models\ExchangeRate;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ExchangeRepository implements ExchangeRepositoryInrterface
{
    public function getExchangeRates(): Collection
    {
        try {
             return ExchangeRate::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error("Error ExchangeRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ExchangeRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }
}
