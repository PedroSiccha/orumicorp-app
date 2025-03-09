<?php
namespace App\Interfaces;

use App\Http\Requests\EditCustomerRequest;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customers;
use App\Models\CustomerStatus;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ClientRepositoryInterface
{
    public function getAllClients(int $limit, array $relations = []): LengthAwarePaginator;
    public function getClients(): Collection;
    public function getClientsByAgent(int $agentId, int $limit, array $relations = []): LengthAwarePaginator;
    public function getAllStatusCustomers(): Collection;
    public function getClientByUserId(int $userId): ?Customers;
    public function getUnassignedClients(): Collection;
    public function getClientByEmail(string $email): ?Customers;
    public function getStatusByName(string $name): ?CustomerStatus;
    public function getClientById(int $userId): ?Customers;
    public function getClientByCode(string $clientCode): ?Customers;
    public function getCustomersByStatusAndRole($customerStatusId, $roles, $agentId): LengthAwarePaginator;
    public function getCustomerStatus(): ?CustomerStatus;
    public function getClientsByFolderExceptStatus(int $folderId, array $status): Collection;
    public function getClientsByFolder(int $folderId): Collection;
    public function getClientsByAssignedUser(int $agentId, int $pagination): LengthAwarePaginator;
    public function getCantClientsRegisterByProvider(int $providerId, string $nowMonth, string $nowYear): int;
    public function getCantClientsActiveByProvider(int $providerId, string $nowMonth, string $nowYear): int;
    public function getCantClientsByProvider(int $providerId, string $nowYear): int;
    public function getListClientsProvider(int $providerId, string $nowMonth, string $nowYear): Collection;
    public function getClientsByStatus(int $statusId): Collection;

    public function searchClientsByStatus(int $statusId, int $limit = 10, array $relations = []): LengthAwarePaginator;
    public function searchClientsByStatusByAgent(int $statusId, int $agentId, int $limit = 10, array $relations = []): LengthAwarePaginator;

    public function createClient(StoreCustomerRequest $data): Customers;

    public function updateStatus(array $customerIds, int $statusId): void;     
    public function updateClientStatus(int $clientId, bool $status): bool;
    public function updateClient(Customers $customer, StoreCustomerRequest $data): bool;
    public function changeFolderClient(Customers $customer, StoreCustomerRequest $data): bool;

    public function deleteClient(Customers $customerId): bool;    
}
