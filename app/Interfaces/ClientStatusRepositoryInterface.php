<?php
namespace App\Interfaces;

use App\Http\Requests\StoreCustomerStatusRequest;
use App\Models\CustomerStatus;
use Illuminate\Database\Eloquent\Collection;

interface ClientStatusRepositoryInterface
{
    public function findStatusByName(string $name): ?CustomerStatus;
    public function findStatusById(string $customerStatusId): ?CustomerStatus;
    public function getCustomerStatus(): Collection;
    public function saveCustomerStatus(StoreCustomerStatusRequest $data): ?CustomerStatus;
    public function updateCustomerStatus(CustomerStatus $customerStatus, StoreCustomerStatusRequest $data): bool;
    public function deleteCustomerStatus(int $customerStatusId): bool;
}
