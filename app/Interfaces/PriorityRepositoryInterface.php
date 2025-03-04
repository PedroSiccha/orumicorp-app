<?php
namespace App\Interfaces;

use App\Models\Priority;
use Illuminate\Database\Eloquent\Collection;

interface PriorityRepositoryInterface
{
    public function getAllPriorities(): Collection;
    public function getPriorities(): Collection;
    public function findPriorityById(int $priorityId): ?Priority;
}
