<?php
namespace App\Interfaces;

use App\Http\Requests\EditCustomerStatusRequest;
use App\Http\Requests\StoreCustomerStatusRequest;
use App\Models\CustomerStatus;
use App\Models\Task;
use App\Models\Traiding;
use Illuminate\Database\Eloquent\Collection;

interface ClientStatusRepositoryInterface
{
    public function findStatusByName(string $name): ?CustomerStatus;
    public function getCustomerStatus(): Collection;
    public function saveCustomerStatus(StoreCustomerStatusRequest $data): ?CustomerStatus;
    public function updateCustomerStatus(CustomerStatus $customerStatus, EditCustomerStatusRequest $data): bool;
    public function deleteCustomerStatus(int $customerStatusId): bool;
}
