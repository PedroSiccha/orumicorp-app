<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Http\Requests\SaveAreaRequest;
use App\Http\Requests\StoreareaRequest;
use App\Http\Requests\UpdateareaRequest;
use App\Interfaces\AreaRepositoryInterface;
use App\Models\Area;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class AreaRepository implements AreaRepositoryInterface
{
    public function getAllAreas(): Collection
    {
        try {
            return Area::all();
        } catch (QueryException $e) {
            Log::error("Error AreaRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AreaRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveArea(StoreareaRequest $data): Area
    {
        try {
            return Area::create($data);
        } catch (QueryException $e) {
            Log::error("Error AreaRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AreaRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getAreas(): Collection
    {
        try {
            return Area::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error("Error AreaRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AreaRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function updateArea(Area $area, StoreareaRequest $data): bool
    {
        try {
            $area->fill($data->validated());
            if (!$area->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error AreaRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AreaRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getAreaById(int $areaId): ?Area
    {
        try {
            return Area::find($areaId);
        } catch (QueryException $e) {
            Log::error("Error AreaRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AreaRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function changeStatusArea(Area $area, bool $status): bool
    {
        try {
            $area->status = $status;
            if (!$area->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error AreaRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error AreaRepository: " . $e->getMessage());
            return false;
        }
    }

    public function deleteArea(int $areaId): bool
    {
        try {
            $area = Area::find($areaId);
            if (!$area) {
                return false;
            }
            if (!$area->delete()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error AreaRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error AreaRepository: " . $e->getMessage());
            return false;
        }
    }
}
