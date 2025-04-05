<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Interfaces\ProviderRepositoryInterface;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ProviderRepository implements ProviderRepositoryInterface
{
    public function getAll(): Collection
    {
        try {
            return Provider::all();
        } catch (QueryException $e) {
            Log::error('ProviderRepository@getAll: ' . $e->getMessage());
            throw new RepositoryException('Error al obtener todos los proveedores.');
        }
    }

    public function getProvidersByCustomer(int $customerId): Collection
    {
        try {
            return Provider::whereHas('customers', function($query) use ($customerId) {
                $query->where('customer_id', $customerId);
            })->with('customers')->get();
        } catch (QueryException $e) {
            Log::error('ProviderRepository@getProvidersByCustomer: ' . $e->getMessage());
            throw new RepositoryException('Error al obtener proveedores por cliente.');
        }
    }

    public function getLastProviderByCustomer(int $customerId): ?Provider
    {
        try {
            return Provider::whereHas('customers', function($query) use ($customerId) {
                $query->where('customer_id', $customerId);
            })
            ->with('customers')
            ->orderByDesc('created_at')
            ->first();
        } catch (QueryException $e) {
            Log::error('ProviderRepository@getLastProviderByCustomer: ' . $e->getMessage());
            throw new RepositoryException('Error al obtener último proveedor del cliente.');
        }
    }

    public function save(array $data): Provider
    {
        try {
            return Provider::create($data);
        } catch (QueryException $e) {
            Log::error('ProviderRepository@save: ' . $e->getMessage());
            throw new RepositoryException('Error al guardar proveedor.');
        }
    }

    public function update(Provider $provider, array $data): bool
    {
        try {
            return $provider->update($data);
        } catch (QueryException $e) {
            Log::error('ProviderRepository@update: ' . $e->getMessage());
            throw new RepositoryException('Error al actualizar proveedor.');
        }
    }

    public function delete(int $providerId): bool
    {
        try {
            return Provider::destroy($providerId) > 0;
        } catch (QueryException $e) {
            Log::error('ProviderRepository@delete: ' . $e->getMessage());
            throw new RepositoryException('Error al eliminar proveedor.');
        }
    }

    public function getProviderByUser(int $userId): ?Provider
    {
        try {
            return Provider::where('user_id', $userId)->first();
        } catch (QueryException $e) {
            Log::error('ProviderRepository@getProviderByUser: ' . $e->getMessage());
            throw new RepositoryException('Error al obtener proveedor por usuario.');
        }
    }

    public function findById(int $providerId): ?Provider
    {
        try {
            return Provider::find($providerId);
        } catch (QueryException $e) {
            Log::error('ProviderRepository@findById: ' . $e->getMessage());
            throw new RepositoryException('Error al buscar proveedor por ID.');
        }
    }
}
