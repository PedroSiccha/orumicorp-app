<?php
namespace App\Repositories;

use App\Http\Requests\EditCustomerStatusRequest;
use App\Http\Requests\StoreCustomerStatusRequest;
use App\Interfaces\ClientStatusRepositoryInterface;
use App\Models\CustomerStatus;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ClientStatusRepository implements ClientStatusRepositoryInterface
{
    public function findStatusByName(string $name): ?CustomerStatus
    {
        try {
            return CustomerStatus::where('name', $name)->first();
        } catch (QueryException $e) {
            Log::error("Error ClientStatusRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ClientStatusRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getCustomerStatus(): Collection
    {
        try {
             return CustomerStatus::get();
        } catch (QueryException $e) {
            Log::error("Error ClientStatusRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ClientStatusRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveCustomerStatus(StoreCustomerStatusRequest $data): ?CustomerStatus
    {
        try {
            return CustomerStatus::create($data);
        } catch (QueryException $e) {
            Log::error("Error ClientStatusRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ClientStatusRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function updateCustomerStatus(CustomerStatus $customerStatus, EditCustomerStatusRequest $data): bool
    {
        try {
            $customerStatus->fill($data->validated());
            if (!$customerStatus->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error ClientStatusRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error ClientStatusRepository: " . $e->getMessage());
            return false;
        }
    }

    public function deleteCustomerStatus(int $customerStatusId): bool
    {
        try {
            $customerStatus = CustomerStatus::find($customerStatusId);
            if (!$customerStatus) {
                return false;
            }
            if (!$customerStatus->delete()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error ClientStatusRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error ClientStatusRepository: " . $e->getMessage());
            return false;
        }
    }
}
