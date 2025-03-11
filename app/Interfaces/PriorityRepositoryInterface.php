<?php
namespace App\Interfaces;

use App\Models\Priority;
use Illuminate\Database\Eloquent\Collection;

interface PriorityRepositoryInterface
{
    public function getAll(): Collection;
    public function getActive(): Collection;
    public function findById(int $priorityId): ?Priority;
    public function save(array $data): Priority;
    public function update(Priority $priority, array $data): bool;
    public function delete(int $priorityId): bool;
}
