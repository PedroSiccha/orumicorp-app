<?php
namespace App\Contracts\Repositories;

use App\Models\Shooter;

interface ShooterRepositoryInterface
{
    public function getShooter(): ?Shooter;
    public function saveShooter(array $data): Shooter;
    public function disableShooter(Shooter $shooter): bool;
    public function findShooterById(int $shooterId): ?Shooter;
}
