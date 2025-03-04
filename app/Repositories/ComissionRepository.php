<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Interfaces\ComissionRepositoryInterface;
use App\Models\Commission;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ComissionRepository implements ComissionRepositoryInterface
{
    public function getComissions(): Collection
    {
        try {
             return Commission::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error("Error ComissionRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ComissionRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }
}
