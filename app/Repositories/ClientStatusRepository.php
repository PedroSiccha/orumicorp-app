<?php
namespace App\Repositories;

use App\Contracts\Repositories\ClientStatusRepositoryInterface;
use App\Models\CustomerStatus;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ClientStatusRepository implements ClientStatusRepositoryInterface
{
    public function findByName(string $name): ?CustomerStatus
    {
        try {
            return CustomerStatus::where('name', $name)->first();
        } catch (QueryException $e) {
            Log::error('ClientStatusRepository@findByName: ' . $e->getMessage());
            throw new Exception('Error al buscar estado por nombre.');
        }
    }

    public function findById(int $customerStatusId): ?CustomerStatus
    {
        try {
            return CustomerStatus::find($customerStatusId);
        } catch (QueryException $e) {
            Log::error('ClientStatusRepository@findById: ' . $e->getMessage());
            throw new Exception('Error al obtener estado por ID.');
        }
    }

    public function getAll(): Collection
    {
        try {
            return CustomerStatus::all();
        } catch (QueryException $e) {
            Log::error('ClientStatusRepository@getAll: ' . $e->getMessage());
            throw new Exception('Error al obtener estados de cliente.');
        }
    }

    public function save(array $data): CustomerStatus
    {
        try {
            return CustomerStatus::create($data);
        } catch (QueryException $e) {
            Log::error('ClientStatusRepository@save: ' . $e->getMessage());
            throw new Exception('Error al crear estado de cliente.');
        }
    }

    public function update(CustomerStatus $customerStatus, array $data): bool
    {
        try {
            return $customerStatus->update($data);
        } catch (QueryException $e) {
            Log::error('ClientStatusRepository@update: ' . $e->getMessage());
            throw new Exception('Error al actualizar estado de cliente.');
        }
    }

    public function delete(int $customerStatusId): bool
    {
        try {
            $status = CustomerStatus::find($customerStatusId);
            if (!$status) {
                return false;
            }
            return $status->delete();
        } catch (QueryException $e) {
            Log::error('ClientStatusRepository@delete: ' . $e->getMessage());
            throw new Exception('Error al eliminar estado de cliente.');
        }
    }
}
