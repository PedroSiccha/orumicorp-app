<?php
namespace App\Contracts\Repositories;

use App\Models\Customers;
use App\Models\CustomerStatus;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ClientRepositoryInterface
{
    public function getAllPaginated(int $limit = 10, array $relations = []): LengthAwarePaginator;
    public function getByAgentPaginated(int $agentId, int $limit = 10, array $relations = []): LengthAwarePaginator;
    public function create(array $data): Customers;
    public function update(Customers $customer, array $data): bool;
    public function findById(int $clientId, array $relations = []): ?Customers;
    public function findByEmail(string $email): ?Customers;
    public function updateStatus(array $customerIds, int $statusId): bool;
    public function getAllStatus(): Collection;
    public function getClientsByFolder(int $folderId, array $excludeStatuses = []): Collection;
    public function getClients(): Collection;
    public function getClientByUserId(int $userId): ?Customers;
    public function getUnassignedClients(): Collection;
    public function getStatusByName(string $name): ?CustomerStatus;
    public function getClientByCode(string $clientCode): ?Customers;
    public function getCustomersByStatusAndRole($customerStatusId, $roles, $agentId): LengthAwarePaginator;
    public function getCustomerStatus(): Collection;
    public function getClientsByFolderExceptStatus(int $folderId, array $status): Collection;
    public function getClientsByAssignedUser(int $agentId, int $pagination): LengthAwarePaginator;
    public function getCantClientsRegisterByProvider(int $providerId, string $nowMonth, string $nowYear): int;
    public function getCantClientsActiveByProvider(int $providerId, string $nowMonth, string $nowYear): int;
    public function getCantClientsByProvider(int $providerId, string $nowYear): int;
    public function getListClientsProvider(int $providerId, string $nowMonth, string $nowYear): Collection;
    public function getClientsByStatus(int $statusId): Collection;
    public function searchClientsByStatus(int $statusId, int $limit = 10, array $relations = []): LengthAwarePaginator;
    public function searchClientsByStatusByAgent(int $statusId, int $agentId, int $limit = 10, array $relations = []): LengthAwarePaginator;
    public function updateClientStatus(int $clientId, bool $status): bool;
    public function changeFolderClient(Customers $customer, array $data): bool;
    public function deleteClient(Customers $customerId): bool;    
}
