<?php
namespace App\Contracts\Repositories;

use App\Models\Assignment;
use Illuminate\Support\Collection;

interface AssignmentRepositoryInterface
{
    public function getActiveAssignments(int $customerId): Collection;
    public function deactivateAssignments(Collection $assignments): void;
    public function createAssignment(array $data): Assignment;
    public function createAssignments(array $assignments): void;
    public function getLatestActiveAssignmentByCustomer(int $customerId): ?Assignment;
    public function getLocationsByCustomer(int $customerId): ?Assignment;
}
