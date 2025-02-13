<?php
namespace App\Repositories\Contracts;

use App\Models\Assignment;
use Illuminate\Support\Collection;

interface AssignmentRepositoryInterface
{
    public function getActiveAssignments(int $customerId): Collection;
    public function deactivateAssignments(Collection $assignments): void;
    public function createAssignment(array $data): Assignment;
    public function createAssignments(array $assignments): void;
    public function getLastAssignmentByCustomer(int $customerId): ?Assignment;
}
