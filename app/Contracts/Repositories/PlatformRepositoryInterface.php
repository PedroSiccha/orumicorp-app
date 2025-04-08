<?php
namespace App\Contracts\Repositories;

use App\Models\Platform;
use Illuminate\Database\Eloquent\Collection;

interface PlatformRepositoryInterface
{
    public function getAllPlatforms(): Collection;
    public function getActivePlatforms(): Collection;
    public function findById(int $platformId): ?Platform;
    public function save(array $data): Platform;
    public function update(Platform $platform, array $data): bool;
    public function delete(int $platformId): bool;
}
