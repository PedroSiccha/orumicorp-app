<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Interfaces\ClientRepositoryInterface;
use App\Models\Customers;
use App\Models\CustomerStatus;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ClientRepository implements ClientRepositoryInterface
{
    public function getAllClients(int $limit = 10, array $relations = []): LengthAwarePaginator
    {
        try {
            return Customers::with($relations)
                    ->orderBy('date_admission', 'desc')
                    ->paginate($limit);
        } catch (QueryException $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getClientsByAgent(int $agentId, int $limit = 10, array $relations = []): LengthAwarePaginator
    {
        try {
            return Customers::with($relations)
                ->whereHas('assignaments', function ($query) use ($agentId) {
                    $query->where('agent_id', $agentId);
                })
                ->orderBy('date_admission', 'desc')
                ->paginate($limit);
        } catch (QueryException $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getAllStatusCustomers(): Collection
    {
        try {
            return CustomerStatus::all();
        } catch (QueryException $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getClientByUserId(int $userId): ?Customers
    {
        try {
            return Customers::where('user_id', $userId)->first();
        } catch (QueryException $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getUnassignedClients(): Collection
    {
        try {
            return Customers::whereNull('agent_id')
                        ->where('status', 1)
                        ->orderBy('date_admission')
                        ->get();
        } catch (QueryException $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function createClient(StoreCustomerRequest $data): Customers
    {
        try {
            return Customers::create($data);
        } catch (QueryException $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getClientByEmail(string $email): ?Customers
    {
        try {
            return Customers::where('email', $email)->first();
        } catch (QueryException $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getStatusByName(string $name): ?CustomerStatus
    {
        try {
            return CustomerStatus::where('name', $name)->firstOrFail();
        } catch (QueryException $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function updateStatus(array $customerIds, int $statusId): void
    {
        try {
            Customers::whereIn('id', $customerIds)->update(['id_status' => $statusId]);
        } catch (QueryException $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function searchClientsByStatus(int $statusId, int $limit = 10, array $relations = []): LengthAwarePaginator
    {
        try {
            return Customers::with($relations)
                            ->where('id_status', $statusId)
                            ->orderBy('date_admission', 'desc')
                            ->paginate($limit);
        } catch (QueryException $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ClientRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function searchClientsByStatusByAgent(int $statusId, int $agentId, int $limit = 10, array $relations = []): LengthAwarePaginator
    {
        try {
            return Customers::with(array_merge($relations, ['assignaments']))
                            ->whereHas('assignaments', function ($query) use ($agentId) {
                                $query->where('agent_id', $agentId);
                            })
                            ->where('id_status', $statusId)
                            ->orderBy('date_admission', 'desc')
                            ->paginate($limit);
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getClientById(int $clientId): ?Customers
    {
        try {
            return Customers::find($clientId);
        } catch (QueryException $e) {
            Log::error("Error al obtener cliente por ID: " . $e->getMessage());    
            return null;
        } catch (Exception $e) {
            Log::error("Error inesperado al obtener cliente por ID: " . $e->getMessage());
            return null;
        }
    }

    public function updateClientStatus(int $clientId, bool $status): bool
    {
        try {
            $client = Customers::find($clientId);
            if (!$client) {
                return false;
            }

            $client->status = $status;
            return $client->save();
        } catch (QueryException $e) {
            Log::error("Error al actualizar el estado del cliente: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error inesperado al actualizar el estado del cliente: " . $e->getMessage());
            return false;
        }
    }

    public function updateClient(Customers $customer, StoreClientRequest $data): bool
    {
        try {
            $customer->fill($data->validated());
            if (!$customer->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error al actualizar el cliente: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error inesperado al actualizar el cliente: " . $e->getMessage());
            return false;
        }
    }

    public function deleteClient(Customers $customer): bool
    {
        try {
            if (!$customer->delete()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error al eliminar el cliente: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error inesperado al eliminar el cliente: " . $e->getMessage());
            return false;
        }
    }

    public function getCustomersByStatusAndRole($customerStatusId, $roles, $agentId, int $limit = 10): LengthAwarePaginator
    {
        try {
            $query = Customers::with([
                'user',
                'agent',
                'latestCampaign',
                'latestSupplier',
                'provider',
                'statusCustomer',
                'platform',
                'traiding',
                'latestComunication',
                'latestAssignamet',
                'latestDeposit'
            ]);
    
            if ($roles !== 'ADMINISTRADOR') {
                $query->whereHas('assignaments', function ($q) use ($agentId) {
                    $q->where('agent_id', $agentId);
                });
                return $query->where('id_status', $customerStatusId)
                             ->orderBy('date_admission', 'desc')
                             ->paginate($limit);
            }
    
            return $query->where('id_status', $customerStatusId)
                         ->orderBy('date_admission', 'desc')
                         ->paginate($limit);
        } catch (QueryException $e) {
            Log::error("Error al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error inesperado al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }   
    }

    
    public function getClients(): Collection
    {
        try {
            return Customers::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error("Error al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error inesperado al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    
    public function getClientByCode(string $clientCode): ?Customers
    {
        try {
            return Customers::where('code', $clientCode)->first();
        } catch (QueryException $e) {
            Log::error("Error al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error inesperado al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    
    public function getCustomerStatus(): ?CustomerStatus
    {
        try {
            return CustomerStatus::get();
        } catch (QueryException $e) {
            Log::error("Error al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error inesperado al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getClientsByFolderExceptStatus(int $folderId, array $status): Collection
    {
        try {
            return Customers::where('folder_id', $folderId)->whereNotIn('id_status', $status)->get();
        } catch (QueryException $e) {
            Log::error("Error al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error inesperado al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getClientsByFolder(int $folderId): Collection
    {
        try {
            return Customers::where('status', StatusEnum::ACTIVE->value)->where('folder_id', $folderId)->get();
        } catch (QueryException $e) {
            Log::error("Error al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error inesperado al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getClientsByAssignedUser(int $agentId, int $pagination): LengthAwarePaginator
    {
        try {
            return Customers::where('agent_id', $agentId)->paginate($pagination, ['*'], 'clients_page')->withQueryString();
        } catch (QueryException $e) {
            Log::error("Error al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error inesperado al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    
    public function getCantClientsRegisterByProvider(int $providerId, string $nowMonth, string $nowYear): int
    {
        try {
            return Customers::where('id_provider', $providerId)->whereMonth('date_admission', $nowMonth)->whereYear('date_admission', $nowYear)->count();
        } catch (QueryException $e) {
            Log::error("Error al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error inesperado al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getCantClientsActiveByProvider(int $providerId, string $nowMonth, string $nowYear): int
    {
        try {
            return Customers::where('id_provider', $providerId)->whereHas('deposits', function($query) use ($nowMonth, $nowYear) {
                                                        $query->whereMonth('date', $nowMonth)
                                                            ->whereYear('date', $nowYear);
                                                    })->distinct('id')->count();
        } catch (QueryException $e) {
            Log::error("Error al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error inesperado al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getCantClientsByProvider(int $providerId, string $nowYear): int
    {
        try {
            return Customers::where('id_provider', $providerId)->whereYear('date_admission',  $nowYear)->count();
        } catch (QueryException $e) {
            Log::error("Error al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error inesperado al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getListClientsProvider(int $providerId, string $nowMonth, string $nowYear): Collection
    {
        try {
            return Customers::where('id_provider', $providerId)->whereMonth('date_admission',$nowMonth)->whereYear('date_admission', $nowYear)->with('statusCustomer')->get();
        } catch (QueryException $e) {
            Log::error("Error al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error inesperado al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getClientsByStatus(int $statusId): Collection
    {
        try {
            return Customers::where('id_status', $statusId)->with(['latestComunication', 'latestCampaign', 'latestSupplier'])->get();
        } catch (QueryException $e) {
            Log::error("Error al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error inesperado al eliminar el cliente: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

}