<?php
namespace App\Contracts\Repositories;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Collection;

interface ProviderRepositoryInterface
{
    public function getAll(): Collection;
    public function getProvidersByCustomer(int $customerId): Collection;
    public function getLastProviderByCustomer(int $customerId): ?Provider;
    public function save(array $data): Provider;
    public function update(Provider $provider, array $data): bool;
    public function delete(int $providerId): bool;
    public function getProviderByUser(int $userId): ?Provider;
    public function findById(int $providerId): ?Provider;
}
