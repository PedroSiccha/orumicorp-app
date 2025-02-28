<?php
namespace App\Interfaces;

use App\Models\Customers;
use App\Models\CustomerStatus;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ClientRepositoryInterface
{
    public function getAllClients(int $limit, array $relations = []): LengthAwarePaginator;
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

    public function searchClientsByStatus(int $statusId, int $limit = 10, array $relations = []): LengthAwarePaginator;
    public function searchClientsByStatusByAgent(int $statusId, int $agentId, int $limit = 10, array $relations = []): LengthAwarePaginator;

    public function createClient(array $data): Customers;
    
    public function updateStatus(array $customerIds, int $statusId): void;    
    public function updateClientStatus(int $clientId, bool $status): bool;
    public function updateClient(Customers $customer, array $data): bool;

    public function deleteClient(Customers $customer): bool;
    

    

}
