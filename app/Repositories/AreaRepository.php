<?php
namespace App\Repositories;

use App\Enums\StatusIntEnum;
use App\Contracts\Repositories\AreaRepositoryInterface;
use App\Models\Area;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class AreaRepository implements AreaRepositoryInterface
{
    public function getAll(): Collection
    {
        try {
            return Area::all();
        } catch (QueryException $e) {
            Log::error('AreaRepository@getAll: ' . $e->getMessage());
            throw new Exception('Error al obtener áreas.');
        }
    }

    public function getAllActive(): Collection
    {
        try {
            return Area::where('status', StatusIntEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error('AreaRepository@getAllActive: ' . $e->getMessage());
            throw new Exception('Error al obtener áreas activas.');
        }
    }

    public function save(array $data): Area
    {
        try {
            return Area::create($data);
        } catch (QueryException $e) {
            Log::error('AreaRepository@save: ' . $e->getMessage());
            throw new Exception('Error al crear área.');
        }
    }

    public function update(Area $area, array $data): bool
    {
        try {
            return $area->update($data);
        } catch (QueryException $e) {
            Log::error('AreaRepository@update: ' . $e->getMessage());
            throw new Exception('Error al actualizar área.');
        }
    }

    public function findById(int $areaId): ?Area
    {
        return Area::find($areaId);
    }

    public function changeStatus(int $areaId, bool $status): bool
    {
        try {
            $area = Area::findOrFail($areaId);
            $area->status = $status;
            return $area->save();
        } catch (QueryException $e) {
            Log::error('AreaRepository@changeStatus: ' . $e->getMessage());
            throw new Exception('Error al cambiar estado del área.');
        }
    }

    public function delete(int $areaId): bool
    {
        try {
            $area = Area::find($areaId);
            if (!$area) {
                return false;
            }
            return $area->delete();
        } catch (QueryException $e) {
            Log::error('AreaRepository@delete: ' . $e->getMessage());
            throw new Exception('Error al eliminar área.');
        }
    }
}
