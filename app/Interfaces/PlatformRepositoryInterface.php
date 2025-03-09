<?php
namespace App\Interfaces;

use App\Http\Requests\EditPlatformRequest;
use App\Http\Requests\StorePlatformRequest;
use App\Models\Platform;
use Illuminate\Database\Eloquent\Collection;

interface PlatformRepositoryInterface
{
    public function getAllPlatforms(): Collection;
    public function getPlatforms(): Collection;
    public function findPlatformById(int $platformId): ?Platform;
    public function savePlatform(StorePlatformRequest $data): ?Platform;
    public function updatePlatform(Platform $platform, StorePlatformRequest $data): bool;
    public function deletePlatform(int $platformId): bool;
}
