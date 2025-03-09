<?php
namespace App\Repositories;

use App\Http\Requests\EditProviderRequest;
use App\Http\Requests\StoreProviderRequest;
use App\Interfaces\ProviderRepositoryInterface;
use App\Models\Provider;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ProviderRepository implements ProviderRepositoryInterface
{
    public function getAllProviders(): Collection
    {
        try {
            return Provider::all();
        } catch (QueryException $e) {
            Log::error("Error ProviderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ProviderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getProviders(): Collection
    {
        try {
            return Provider::get();
        } catch (QueryException $e) {
            Log::error("Error ProviderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ProviderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getLastProviderByCustomer(int $customerId): ?Provider
    {
        try {
            return Provider::whereHas('customers', function($query) use ($customerId) {
                        $query->where('customer_id', $customerId);
                    })->with('customers')->orderBy('created_at', 'desc')->first();
        } catch (QueryException $e) {
            Log::error("Error ProviderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ProviderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getAllProvidersByCustomer(int $customerId): Collection
    {
        try {
            return Provider::whereHas('customers', function($query) use ($customerId) {
                        $query->where('customer_id', $customerId);
                    })->with('customers')->get();
        } catch (QueryException $e) {
            Log::error("Error ProviderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ProviderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveProvider(StoreProviderRequest $data): ?Provider
    {
        try {
            return Provider::create($data);
        } catch (QueryException $e) {
            Log::error("Error ProviderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ProviderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function updateProvider(Provider $provider, StoreProviderRequest $data): bool
    {
        try {
            $provider->fill($data->validated());
            if (!$provider->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error ProviderRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error ProviderRepository: " . $e->getMessage());
            return false;
        }
    }

    public function deleteProvider(int $providerId): bool
    {
        try {
            $provider = Provider::find($providerId);
            if (!$provider) {
                return false;
            }
            if (!$provider->delete()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error ProviderRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error ProviderRepository: " . $e->getMessage());
            return false;
        }
    }

    public function getProviderByUser(int $userId): ?Provider
    {
        try {
             return Provider::where('user_id', $userId)->first();
        } catch (QueryException $e) {
            Log::error("Error ProviderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ProviderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function findProviderById(int $providerId): ?Provider
    {
        try {
            return Provider::find($providerId);
       } catch (QueryException $e) {
           Log::error("Error ProviderRepository: " . $e->getMessage());
           throw new Exception("No se encontraron resultados para los filtros aplicados.");
       } catch (Exception $e) {
           Log::error("Error ProviderRepository: " . $e->getMessage());
           throw new Exception("No se encontraron resultados para los filtros aplicados.");
       }
    }
}
