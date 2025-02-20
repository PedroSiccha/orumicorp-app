<?php
namespace App\Interfaces;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Collection;

interface ProviderRepositoryInterface
{
    public function getAllProviders(): Collection;
    public function getLastProviderByCustomer(int $customerId): ?Provider;
    public function getAllProvidersByCustomer(int $customerId): Collection;
}
