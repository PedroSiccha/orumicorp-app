<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Exceptions\RepositoryException;
use App\Contracts\Repositories\PlatformRepositoryInterface;
use App\Models\Platform;
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
            Log::error('PlatformRepository@getAllPlatforms: ' . $e->getMessage());
            throw new RepositoryException('Error al obtener todas las plataformas.');
        }
    }

    public function getActivePlatforms(): Collection
    {
        try {
            return Platform::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error('PlatformRepository@getActivePlatforms: ' . $e->getMessage());
            throw new RepositoryException('Error al obtener plataformas activas.');
        }
    }

    public function save(array $data): Platform
    {
        try {
            return Platform::create($data);
        } catch (QueryException $e) {
            Log::error('PlatformRepository@save: ' . $e->getMessage());
            throw new RepositoryException('Error al guardar plataforma.');
        }
    }

    public function findById(int $platformId): ?Platform
    {
        try {
            return Platform::find($platformId);
        } catch (QueryException $e) {
            Log::error('PlatformRepository@findById: ' . $e->getMessage());
            throw new RepositoryException('Error al buscar plataforma por ID.');
        }
    }

    public function update(Platform $platform, array $data): bool
    {
        try {
            return $platform->update($data);
        } catch (QueryException $e) {
            Log::error('PlatformRepository@update: ' . $e->getMessage());
            throw new RepositoryException('Error al actualizar la plataforma.');
        }
    }

    public function delete(int $platformId): bool
    {
        try {
            return Platform::destroy($platformId) > 0;
        } catch (QueryException $e) {
            Log::error('PlatformRepository@delete: ' . $e->getMessage());
            throw new RepositoryException('Error al eliminar plataforma.');
        }
    }
}
