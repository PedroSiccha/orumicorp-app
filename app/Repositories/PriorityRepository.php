<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Exceptions\RepositoryException;
use App\Contracts\Repositories\PriorityRepositoryInterface;
use App\Models\Priority;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class PriorityRepository implements PriorityRepositoryInterface
{
    public function getAll(): Collection
    {
        try {
            return Priority::all();
        } catch (QueryException $e) {
            Log::error('PriorityRepository@getAll: ' . $e->getMessage());
            throw new RepositoryException('Error al obtener todas las prioridades.');
        }
    }

    public function getActive(): Collection
    {
        try {
            return Priority::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error('PriorityRepository@getActivePriorities: ' . $e->getMessage());
            throw new RepositoryException('Error al obtener prioridades activas.');
        }
    }

    public function findById(int $priorityId): ?Priority
    {
        try {
            return Priority::where('id', $priorityId)
                           ->where('status', StatusEnum::ACTIVE->value)
                           ->first();
        } catch (QueryException $e) {
            Log::error('PriorityRepository@findById: ' . $e->getMessage());
            throw new RepositoryException('Error al obtener prioridad por ID.');
        }
    }

    public function save(array $data): Priority
    {
        try {
            return Priority::create($data);
        } catch (QueryException $e) {
            Log::error('PriorityRepository@save: ' . $e->getMessage());
            throw new RepositoryException('Error al guardar prioridad.');
        }
    }

    public function update(Priority $priority, array $data): bool
    {
        try {
            return $priority->update($data);
        } catch (QueryException $e) {
            Log::error('PriorityRepository@update: ' . $e->getMessage());
            throw new RepositoryException('Error al actualizar prioridad.');
        }
    }

    public function delete(int $priorityId): bool
    {
        try {
            return Priority::destroy($priorityId) > 0;
        } catch (QueryException $e) {
            Log::error('PriorityRepository@delete: ' . $e->getMessage());
            throw new RepositoryException('Error al eliminar prioridad.');
        }
    }
}
