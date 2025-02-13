<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Interfaces\ClientRepositoryInterface;
use App\Models\Customers;
use App\Models\CustomerStatus;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ClientRepository implements ClientRepositoryInterface
{
    public function getAllClients(int $limit = 10, array $relations = []): LengthAwarePaginator
    {
        try {
            return Customers::with($relations)
                    ->orderBy('date_admission', 'desc')
                    ->paginate($limit);
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener los clientes: " . $e->getMessage());
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
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener clientes del agente ID {$agentId}: " . $e->getMessage());
        }
    }

    public function getAllStatusCustomers(): Collection
    {
        try {
            return CustomerStatus::all();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener los estados del cliente: " . $e->getMessage());
        }
    }

    public function getClientByUserId(int $userId): ?Customers
    {
        try {
            return Customers::where('user_id', $userId)->first();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener el cliente del usuario ID {$userId}: " . $e->getMessage());
        }
    }

    public function getUnassignedClients(): Collection
    {
        try {
            return Customers::whereNull('agent_id')
                        ->where('status', 1)
                        ->orderBy('date_admission')
                        ->get();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener los clientes sin asignacion: " . $e->getMessage());
        }
    }

    public function createClient(array $data): Customers
    {
        try {
            return Customers::create($data);
        } catch (Exception $e) {
            throw new RepositoryException("Error al crear el cliente: " . $e->getMessage());
        }
    }

    public function getClientByEmail(string $email): ?Customers
    {
        try {
            return Customers::where('email', $email)->first();
        } catch (Exception $e) {
            throw new RepositoryException("Error no se pudo encontrar el cliente: " . $e->getMessage());
        }
    }

    public function getStatusByName(string $name): ?CustomerStatus
    {
        try {
            return CustomerStatus::where('name', $name)->firstOrFail();
        } catch (Exception $e) {
            throw new RepositoryException("Error no se pudo encontrar el estado: " . $e->getMessage());
        }
    }

    public function updateStatus(array $customerIds, int $statusId): void
    {
        try {
            Customers::whereIn('id', $customerIds)->update(['id_status' => $statusId]);
        } catch (Exception $e) {
            throw new RepositoryException("Error al actualizar el estado: " . $e->getMessage());
        }
    }

    public function searchClientsByStatus(int $statusId, int $limit = 10, array $relations = []): LengthAwarePaginator
    {
        try {
            return Customers::with($relations)
                            ->where('id_status', $statusId)
                            ->orderBy('date_admission', 'desc')
                            ->paginate($limit);
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener clientes del agente ID {$agentId}: " . $e->getMessage());
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
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener clientes del agente ID {$agentId}: " . $e->getMessage());
        }
    }

}

