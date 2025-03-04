<?php
namespace App\Interfaces;

use App\Http\Requests\StoreShooterRequest;
use App\Models\Shooter;

interface ShooterRepositoryInterface
{
    public function getShooter(): ?Shooter;
    public function saveShooter(StoreShooterRequest $data): Shooter;
    public function disableShooter(Shooter $shooter): bool;
}
