<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Http\Requests\EditPlatformRequest;
use App\Http\Requests\StorePlatformRequest;
use App\Interfaces\PlatformRepositoryInterface;
use App\Models\Platform;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class PlatformRepository implements PlatformRepositoryInterface
{
    public function getAllPlatforms(): Collection
    {
        try {
            return Platform::all();
        } catch (QueryException $e) {
            Log::error("Error PlatformRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error PlatformRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getPlatforms(): Collection
    {
        try {
             return Platform::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error("Error PlatformRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error PlatformRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function savePlatform(StorePlatformRequest $data): ?Platform
    {
        try {
            return Platform::create($data);
        } catch (QueryException $e) {
            Log::error("Error PlatformRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error PlatformRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function updatePlatform(Platform $platform, EditPlatformRequest $data): bool
    {
        try {
            $platform->fill($data->validate());
            if (!$platform->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error PlatformRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error PlatformRepository: " . $e->getMessage());
            return false;
        }
    }

    public function deletePlatform(int $platformId): bool
    {
        try {
            $platform = Platform::find($platformId);
            if (!$platform) {
                return false;
            }
            if (!$platform->delete()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error PlatformRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error PlatformRepository: " . $e->getMessage());
            return false;
        }
    }
}
