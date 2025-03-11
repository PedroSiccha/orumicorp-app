<?php
namespace App\Interfaces;

use App\Models\Traiding;
use Illuminate\Database\Eloquent\Collection;

interface TraidingRepositoryInterface
{
    public function getAllTraidings(): Collection;
    public function getActiveTraidings(): Collection;
    public function saveTraiding(array $data): ?Traiding;
    public function findTraidingById(int $traidingId): ?Traiding;
    public function updateTraiding(Traiding $traiding, array $data): bool;
    public function deleteTraiding(int $traidingId): bool;
}
