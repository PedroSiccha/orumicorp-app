<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Interfaces\ClientRepositoryInterface;
use App\Models\Customers;
use App\Models\CustomerStatus;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Throwable;

class ClientRepository implements ClientRepositoryInterface
{
    public function getAllPaginated(int $limit = 10, array $relations = []): LengthAwarePaginator
    {
        try {
            return Customers::with($relations)
                ->orderBy('date_admission', 'desc')
                ->paginate($limit);
        } catch (QueryException $e) {
            Log::error('ClientRepository@getAllPaginated: ' . $e->getMessage());
            throw new Exception('Error al obtener clientes.');
        }
    }

    public function getByAgentPaginated(int $agentId, int $limit = 10, array $relations = []): LengthAwarePaginator
    {
        try {
            return Customers::with($relations)
                ->where('agent_id', $agentId)
                ->orderBy('date_admission', 'desc')
                ->paginate($limit);
        } catch (QueryException $e) {
            Log::error('ClientRepository@getByAgentPaginated: ' . $e->getMessage());
            throw new Exception('Error al obtener clientes por agente.');
        }
    }

    public function create(array $data): Customers
    {
        try {
            return Customers::create($data);
        } catch (QueryException $e) {
            Log::error('ClientRepository@create: ' . $e->getMessage());
            throw new Exception('Error al crear cliente.');
        }
    }

    public function update(Customers $customer, array $data): bool
    {
        try {
            return $customer->update($data);
        } catch (QueryException $e) {
            Log::error('ClientRepository@update: ' . $e->getMessage());
            throw new Exception('Error al actualizar cliente.');
        }
    }

    public function findById(int $clientId, array $relations = []): ?Customers
    {
        try {
            return Customers::with($relations)->find($clientId);
        } catch (QueryException $e) {
            Log::error('ClientRepository@findById: ' . $e->getMessage());
            throw new Exception('Error al buscar cliente.');
        }
    }

    public function findByEmail(string $email): ?Customers
    {
        try {
            return Customers::where('email', $email)->first();
        } catch (QueryException $e) {
            Log::error('ClientRepository@findByEmail: ' . $e->getMessage());
            throw new Exception('Error al buscar cliente por email.');
        }
    }

    public function updateStatus(array $customerIds, int $statusId): bool
    {
        try {
            return Customers::whereIn('id', $customerIds)->update(['id_status' => $statusId]) > 0;
        } catch (QueryException $e) {
            Log::error('ClientRepository@updateStatus: ' . $e->getMessage());
            throw new Exception('Error al actualizar estado de clientes.');
        }
    }

    public function getAllStatus(): Collection
    {
        try {
            return CustomerStatus::all();
        } catch (QueryException $e) {
            Log::error('ClientRepository@getAllStatus: ' . $e->getMessage());
            throw new Exception('Error al obtener estados de clientes.');
        }
    }

    public function getClientsByFolder(int $folderId, array $excludeStatuses = []): Collection
    {
        try {
            $query = Customers::where('folder_id', $folderId);
            if (!empty($excludeStatuses)) {
                $query->whereNotIn('id_status', $excludeStatuses);
            }
            return $query->get();
        } catch (QueryException $e) {
            Log::error('ClientRepository@getClientsByFolder: ' . $e->getMessage());
            throw new Exception('Error al obtener clientes por carpeta.');
        }
    }

    public function getClients(): Collection
    {
        try {
            $clients = Customers::where('status', StatusEnum::ACTIVE->value)->get();
            if ($clients->isEmpty()) {
                Log::warning("No se encontraron clientes activos.");
            }
            return $clients;
        } catch (Throwable $e) {
            Log::error("Error en ClientRepository - getClients: " . $e->getMessage());
            throw new Exception("Error al obtener la lista de clientes activos.");
        }
    }

    public function getClientByUserId(int $userId): ?Customers
    {
        try {
            $client = Customers::where('user_id', $userId)->first();
            if (!$client) {
                Log::warning("No se encontró un cliente asociado al usuario ID: {$userId}");
            }
            return $client;
        } catch (Throwable $e) {
            Log::error("Error en ClientRepository - getClientByUserId: " . $e->getMessage());
            throw new Exception("Error al obtener el cliente del usuario ID: {$userId}");
        }
    }

    public function getUnassignedClients(): Collection
    {
        try {
            $clients = Customers::whereNull('agent_id')
                                ->where('status', StatusEnum::ACTIVE->value)
                                ->orderBy('date_admission')
                                ->get();
            if ($clients->isEmpty()) {
                Log::warning("No se encontraron clientes sin asignar.");
            }
            return $clients;
        } catch (Throwable $e) {
            Log::error("Error en ClientRepository - getUnassignedClients: " . $e->getMessage());
            throw new Exception("Error al obtener los clientes sin asignar.");
        }
    }

    public function getStatusByName(string $name): ?CustomerStatus
    {
        try {
            $status = CustomerStatus::where('name', $name)->first();
            if (!$status) {
                Log::warning("No se encontró un estado con el nombre: {$name}");
            }
            return $status;
        } catch (Throwable $e) {
            Log::error("Error en ClientRepository - getStatusByName: " . $e->getMessage());
            throw new Exception("Error al obtener el estado del cliente con nombre: {$name}");
        }
    }

    public function getClientByCode(string $clientCode): ?Customers
    {
        try {
            $client = Customers::where('code', $clientCode)->first();
            if (!$client) {
                Log::warning("No se encontró un cliente con el código: {$clientCode}");
            }
            return $client;
        } catch (Throwable $e) {
            Log::error("Error en ClientRepository - getClientByCode: " . $e->getMessage());
            throw new Exception("Error al obtener el cliente con código: {$clientCode}");
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
            ])->where('id_status', $customerStatusId);
            if ($roles !== 'ADMINISTRADOR') {
                $query->whereHas('assignaments', function ($q) use ($agentId) {
                    $q->where('agent_id', $agentId);
                });
            }
            $clients = $query->orderBy('date_admission', 'desc')->paginate($limit);
            if ($clients->isEmpty()) {
                Log::warning("No se encontraron clientes con el estado ID: {$customerStatusId} y rol: {$roles}");
            }
            return $clients;
        } catch (Throwable $e) {
            Log::error("Error en ClientRepository - getCustomersByStatusAndRole: " . $e->getMessage());
            throw new Exception("Error al obtener clientes con el estado ID: {$customerStatusId} y rol: {$roles}");
        }
    }

    public function getCustomerStatus(): Collection
    {
        try {
            $statuses = CustomerStatus::all();
            if ($statuses->isEmpty()) {
                Log::warning("No se encontraron estados de clientes.");
            }
            return $statuses;
        } catch (Throwable $e) {
            Log::error("Error en ClientRepository - getCustomerStatus: " . $e->getMessage());
            throw new Exception("Error al obtener los estados de clientes.");
        }
    }

    public function getClientsByFolderExceptStatus(int $folderId, array $status): Collection
    {
        try {
            $clients = Customers::where('folder_id', $folderId)
                ->whereNotIn('id_status', $status)
                ->with(['statusCustomer', 'agent'])
                ->get();
            if ($clients->isEmpty()) {
                Log::warning("No se encontraron clientes en la carpeta ID: {$folderId}, excluyendo los estados: " . implode(', ', $status));
            }
            return $clients;
        } catch (Throwable $e) {
            Log::error("Error en ClientRepository - getClientsByFolderExceptStatus: " . $e->getMessage());
            throw new Exception("Error al obtener los clientes de la carpeta ID: {$folderId}.");
        }
    }

    public function getClientsByAssignedUser(int $agentId, int $pagination = 10): LengthAwarePaginator
    {
        try {
            $clients = Customers::whereHas('assignaments', function ($query) use ($agentId) {
                    $query->where('agent_id', $agentId);
                })
                ->with(['agent', 'statusCustomer'])
                ->paginate($pagination, ['*'], 'clients_page')
                ->withQueryString();
            if ($clients->isEmpty()) {
                Log::warning("No se encontraron clientes asignados al agente ID: {$agentId}");
            }
            return $clients;
        } catch (Throwable $e) {
            Log::error("Error en ClientRepository - getClientsByAssignedUser: " . $e->getMessage());
            throw new Exception("Error al obtener clientes asignados al agente ID: {$agentId}.");
        }
    }

    public function getCantClientsRegisterByProvider(int $providerId, string $nowMonth, string $nowYear): int
    {
        try {
            $count = Customers::where('provider_id', $providerId)
                ->whereYear('date_admission', $nowYear)
                ->whereMonth('date_admission', $nowMonth)
                ->count();
            if ($count === 0) {
                Log::warning("No se encontraron clientes registrados en el mes {$nowMonth}-{$nowYear} para el proveedor ID: {$providerId}");
            }
            return $count;
        } catch (Throwable $e) {
            Log::error("Error en ClientRepository - getCantClientsRegisterByProvider: " . $e->getMessage());
            throw new Exception("Error al obtener la cantidad de clientes registrados para el proveedor ID: {$providerId}.");
        }
    }

    public function getCantClientsActiveByProvider(int $providerId, string $nowMonth, string $nowYear): int
    {
        try {
            $count = Customers::where('provider_id', $providerId)
                ->where('id_status', StatusEnum::ACTIVE->value)
                ->whereYear('date_admission', $nowYear)
                ->whereMonth('date_admission', $nowMonth)
                ->count();
            if ($count === 0) {
                Log::warning("No se encontraron clientes activos en el mes {$nowMonth}-{$nowYear} para el proveedor ID: {$providerId}");
            }
            return $count;
        } catch (Throwable $e) {
            Log::error("Error en ClientRepository - getCantClientsActiveByProvider: " . $e->getMessage());
            throw new Exception("Error al obtener la cantidad de clientes activos para el proveedor ID: {$providerId}.");
        }
    }

    public function getCantClientsByProvider(int $providerId, string $nowYear): int
    {
        try {
            $count = Customers::where('provider_id', $providerId)
                ->whereYear('date_admission', $nowYear)
                ->count();
            if ($count === 0) {
                Log::warning("No se encontraron clientes registrados en el año {$nowYear} para el proveedor ID: {$providerId}");
            }
            return $count;
        } catch (Throwable $e) {
            Log::error("Error en ClientRepository - getCantClientsByProvider: " . $e->getMessage());
            throw new Exception("Error al obtener la cantidad de clientes del proveedor ID: {$providerId} en el año {$nowYear}.");
        }
    }

    public function getListClientsProvider(int $providerId, string $nowMonth, string $nowYear): Collection
    {
        try {
            $clients = Customers::where('provider_id', $providerId)
                ->whereYear('date_admission', $nowYear)
                ->whereMonth('date_admission', $nowMonth)
                ->with(['statusCustomer', 'agent'])
                ->get();
            if ($clients->isEmpty()) {
                Log::warning("No se encontraron clientes para el proveedor ID: {$providerId} en el mes {$nowMonth}-{$nowYear}");
            }
            return $clients;
        } catch (Throwable $e) {
            Log::error("Error en ClientRepository - getListClientsProvider: " . $e->getMessage());
            throw new Exception("Error al obtener la lista de clientes del proveedor ID: {$providerId}.");
        }
    }

    public function getClientsByStatus(int $statusId): Collection
    {
        try {
            $clients = Customers::where('id_status', $statusId)
                ->with(['statusCustomer', 'agent'])
                ->get();
            if ($clients->isEmpty()) {
                Log::warning("No se encontraron clientes con el estado ID: {$statusId}");
            }
            return $clients;
        } catch (Throwable $e) {
            Log::error("Error en ClientRepository - getClientsByStatus: " . $e->getMessage());
            throw new Exception("Error al obtener clientes con el estado ID: {$statusId}.");
        }
    }

    public function searchClientsByStatus(int $statusId, int $limit = 10, array $relations = []): LengthAwarePaginator
    {
        try {
            $clients = Customers::where('id_status', $statusId)
                ->with($relations)
                ->paginate($limit, ['*'], 'clients_page')
                ->withQueryString();
            if ($clients->isEmpty()) {
                Log::warning("No se encontraron clientes con el estado ID: {$statusId} al realizar la búsqueda paginada.");
            }
            return $clients;
        } catch (Throwable $e) {
            Log::error("Error en ClientRepository - searchClientsByStatus: " . $e->getMessage());
            throw new Exception("Error al buscar clientes con el estado ID: {$statusId}.");
        }
    }

    public function searchClientsByStatusByAgent(int $statusId, int $agentId, int $limit = 10, array $relations = []): LengthAwarePaginator
    {
        try {
            $clients = Customers::where('id_status', $statusId)
                ->where('agent_id', $agentId)
                ->with($relations)
                ->paginate($limit, ['*'], 'clients_page')
                ->withQueryString();
            if ($clients->isEmpty()) {
                Log::warning("No se encontraron clientes con el estado ID: {$statusId} para el agente ID: {$agentId}.");
            }
            return $clients;
        } catch (Throwable $e) {
            Log::error("Error en ClientRepository - searchClientsByStatusByAgent: " . $e->getMessage());
            throw new Exception("Error al buscar clientes con estado ID: {$statusId} y agente ID: {$agentId}.");
        }
    }

    public function updateClientStatus(int $clientId, bool $status): bool
    {
        try {
            $client = Customers::find($clientId);
            if (!$client) {
                Log::warning("Intento de actualización: No se encontró un cliente con el ID: {$clientId}");
                return false;
            }
            $client->status = $status;
            return $client->save();
        } catch (Throwable $e) {
            Log::error("Error en ClientRepository - updateClientStatus: " . $e->getMessage());
            return false;
        }
    }

    public function changeFolderClient(Customers $customer, array $data): bool
    {
        try {
            $newFolderId = $data['folder_id'] ?? null;
            if (!$newFolderId) {
                Log::warning("Intento de cambio de carpeta sin carpeta válida para el cliente ID: {$customer->id}");
                return false;
            }
            $customer->folder_id = $newFolderId;
            return $customer->save();
        } catch (Throwable $e) {
            Log::error("Error en ClientRepository - changeFolderClient: " . $e->getMessage());
            return false;
        }
    }

    public function deleteClient(Customers $customer): bool
    {
        try {
            if (!$customer->delete()) {
                Log::warning("No se pudo eliminar el cliente ID: {$customer->id}");
                return false;
            }
            return true;
        } catch (Throwable $e) {
            Log::error("Error en ClientRepository - deleteClient: " . $e->getMessage());
            return false;
        }
    }
}