<?php
namespace App\Interfaces;

use App\Http\Requests\EditProviderRequest;
use App\Http\Requests\StoreProviderRequest;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Collection;

interface ProviderRepositoryInterface
{
    public function getAllProviders(): Collection;
    public function getProviders(): Collection;
    public function getLastProviderByCustomer(int $customerId): ?Provider;
    public function getAllProvidersByCustomer(int $customerId): Collection;
    public function saveProvider(StoreProviderRequest $data): ?Provider;
    public function updateProvider(Provider $provider, StoreProviderRequest $data): bool;
    public function deleteProvider(int $providerId): bool;
    public function getProviderByUser(int $userId): ?Provider;
    public function findProviderById(int $providerId): ?Provider;
}
