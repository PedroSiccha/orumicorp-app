<?php
namespace App\Interfaces;

use App\Http\Requests\EditTraidingRequest;
use App\Http\Requests\StoreTraidingRequest;
use App\Models\Traiding;
use Illuminate\Database\Eloquent\Collection;

interface TraidingRepositoryInterface
{
    public function getAllTraidings(): Collection;
    public function getTraidings(): Collection;
    public function saveTraiding(StoreTraidingRequest $data): Traiding;
    public function findTraidingById(int $traidingId): ?Traiding;
    public function updateTraiding(Traiding $traiding, EditTraidingRequest $data): bool;
    public function deleteTraiding(int $traidingId): bool;
}
