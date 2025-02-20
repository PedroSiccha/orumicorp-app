<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Models\Assignment;
use App\Repositories\Contracts\AssignmentRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AssignmentRepository implements AssignmentRepositoryInterface
{
    public function getActiveAssignments(int $customerId): Collection
    {
        try {
            return Assignment::where('customer_id', $customerId)
                            ->where('status', 1)
                            ->get();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener las asignaciones activas del cliente {$customerId}: " . $e->getMessage());
        }

    }

    public function deactivateAssignments(Collection $assignments): void
    {
        try {
            foreach ($assignments as $assignment) {
                $assignment->status = 0;
                $assignment->save();
            }
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener las asignaciones inactivas: " . $e->getMessage());
        }

    }

    public function createAssignment(array $data): Assignment
    {
        try {
            return Assignment::create($data);
        } catch (Exception $e) {
            throw new RepositoryException("Error al asignar el cliente: " . $e->getMessage());
        }
    }

    public function createAssignments(array $assignments): void
    {
        try {
            DB::table('assignments')->insert($assignments);
        } catch (Exception $e) {
            throw new RepositoryException("Error al asignar el cliente: " . $e->getMessage());
        }
        
    }

    public function getLastAssignmentByCustomer(int $customerId): ?Assignment
    {
        try {
            return Assignment::with(['agent', 'assignedBy'])
                            ->where('customer_id', $customerId)
                            ->where('status', 1)
                            ->orderBy('date', 'desc')
                            ->first();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener ultima asignación del cliente: " . $e->getMessage());
        }
        
    }

    public function getLocationsByCustomer(int $customerId): ?Assignment
    {
        try {
            return Assignment::with(['agent', 'assignedBy'])
                            ->where('customer_id', $customerId)
                            ->where('status', true)
                            ->orderBy('status', 'asc')
                            ->first();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener las asignaciones activas del cliente {$customerId}: " . $e->getMessage());
        }
    }
}
