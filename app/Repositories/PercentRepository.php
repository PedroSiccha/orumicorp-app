<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\PercentRepositoryInterface;
use App\Models\Percent;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class PercentRepository implements PercentRepositoryInterface
{
    public function getPercents(): Collection
    {
        try {
             return Percent::where('status', true)->get();
        } catch (QueryException $e) {
            Log::error("Error PercentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error PercentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

}
