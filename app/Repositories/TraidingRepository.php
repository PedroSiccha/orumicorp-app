<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Interfaces\TraidingRepositoryInterface;
use App\Models\Traiding;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class TraidingRepository implements TraidingRepositoryInterface
{
    public function getAllTraidings(): Collection
    {
        try {
            return Traiding::all();
        } catch (QueryException $e) {
            Log::error("Error TraidingRepository@getAllTraidings: " . $e->getMessage());
            throw new Exception("No se encontraron resultados.");
        }
    }

    public function getActiveTraidings(): Collection
    {
        try {
            return Traiding::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error("Error TraidingRepository@getTraidings: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function findTraidingById(int $traidingId): ?Traiding
    {
        try {
            return Traiding::find($traidingId);
        } catch (QueryException $e) {
            Log::error("Error TraidingRepository@findTraidingById: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveTraiding(array $data): ?Traiding
    {
        try {
            return Traiding::create($data);
        } catch (QueryException $e) {
            Log::error("Error TraidingRepository@saveTraiding: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }


    public function updateTraiding(Traiding $traiding, array $data): bool
    {
        try {
            $traiding->fill($data);
            return $traiding->save();
        } catch (QueryException $e) {
            Log::error("Error TraidingRepository@updateTraiding: " . $e->getMessage());
            return false;
        }
    }

    public function deleteTraiding(int $traidingId): bool
    {
        try {
            $traiding = Traiding::find($traidingId);
            if (!$traiding) {
                return false;
            }
            return $traiding->delete();
        } catch (QueryException $e) {
            Log::error("Error TraidingRepository@deleteTraiding: " . $e->getMessage());
            return false;
        }
    }
}
