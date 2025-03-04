<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Http\Requests\EditTraidingRequest;
use App\Http\Requests\StoreTraidingRequest;
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
            Log::error("Error TraidingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error TraidingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getTraidings(): Collection
    {
        try {
             return Traiding::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error("Error TraidingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error TraidingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveTraiding(StoreTraidingRequest $data): Traiding
    {
        try {
            return Traiding::create($data);
        } catch (QueryException $e) {
            Log::error("Error TraidingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error TraidingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function findTraidingById(int $traidingId): ?Traiding
    {
        try {
            return Traiding::find($traidingId);
        } catch (QueryException $e) {
            Log::error("Error TraidingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error TraidingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function updateTraiding(Traiding $traiding, EditTraidingRequest $data): bool
    {
        try {
            $traiding->fill($data->validated());
            if (!$traiding->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error TraidingRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error TraidingRepository: " . $e->getMessage());
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
            if (!$traiding->delete()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error TraidingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error TraidingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }
}
