<?php
namespace App\Interfaces;

use App\Models\CustomerStatus;
use Illuminate\Database\Eloquent\Collection;

interface ClientStatusRepositoryInterface
{
    public function findByName(string $name): ?CustomerStatus;
    public function findById(int $customerStatusId): ?CustomerStatus;
    public function getAll(): Collection;
    public function save(array $data): CustomerStatus;
    public function update(CustomerStatus $customerStatus, array $data): bool;
    public function delete(int $customerStatusId): bool;
}
