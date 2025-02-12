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
    public function createClient(array $data): Customers;
    public function getStatusByName(string $name): ?CustomerStatus;

}
