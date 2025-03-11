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
    public function getActiveCommissions(): Collection
    {
        try {
            return Commission::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error('ComissionRepository@getActiveCommissions: ' . $e->getMessage());
            throw new Exception('Error al obtener comisiones activas.');
        }
    }

    public function getAllCommissions(): Collection
    {
        try {
            return Commission::all();
        } catch (QueryException $e) {
            Log::error('ComissionRepository@getAllCommissions: ' . $e->getMessage());
            throw new Exception('Error al obtener todas las comisiones.');
        }
    }
}
