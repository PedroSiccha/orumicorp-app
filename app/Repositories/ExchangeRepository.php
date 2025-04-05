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
    public function getActiveExchangeRates(): Collection
    {
        try {
            return ExchangeRate::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error('ExchangeRepository@getActiveExchangeRates: ' . $e->getMessage());
            throw new Exception('Error al obtener los tipos de cambio activos.');
        }
    }

    public function getAllExchangeRates(): Collection
    {
        try {
            return ExchangeRate::all();
        } catch (QueryException $e) {
            Log::error('ExchangeRepository@getAllExchangeRates: ' . $e->getMessage());
            throw new Exception('Error al obtener todos los tipos de cambio.');
        }
    }
}
