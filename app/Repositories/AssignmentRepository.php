<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Models\Assignment;
use App\Contracts\Repositories\AssignmentRepositoryInterface;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class AssignmentRepository implements AssignmentRepositoryInterface
{
    public function getActiveAssignments(int $customerId): Collection
    {
        try {
            return Assignment::where('customer_id', $customerId)
                             ->where('status', StatusEnum::ACTIVE->value)
                             ->get();
        } catch (QueryException $e) {
            Log::error('AssignmentRepository@getActiveAssignments: ' . $e->getMessage());
            throw new Exception('Error al obtener asignaciones activas.');
        }
    }

    public function deactivateAssignments(Collection $assignments): void
    {
        try {
            Assignment::whereIn('id', $assignments->pluck('id'))
                      ->update(['status' => StatusEnum::INACTIVE->value]);
        } catch (QueryException $e) {
            Log::error('AssignmentRepository@deactivateAssignments: ' . $e->getMessage());
            throw new Exception('Error al desactivar asignaciones.');
        }
    }

    public function createAssignment(array $data): Assignment
    {
        try {
            return Assignment::create($data);
        } catch (QueryException $e) {
            Log::error('AssignmentRepository@createAssignment: ' . $e->getMessage());
            throw new Exception('Error al crear asignación.');
        }
    }

    public function createAssignments(array $assignments): void
    {
        try {
            DB::table('assignments')->insert($assignments);
        } catch (QueryException $e) {
            Log::error('AssignmentRepository@createAssignments: ' . $e->getMessage());
            throw new Exception('Error al crear múltiples asignaciones.');
        }
    }

    public function getLatestActiveAssignmentByCustomer(int $customerId): ?Assignment
    {
        try {
            return Assignment::with(['agent', 'assignedBy'])
                             ->where('customer_id', $customerId)
                             ->where('status', StatusEnum::ACTIVE->value)
                             ->orderBy('date', 'desc')
                             ->first();
        } catch (QueryException $e) {
            Log::error('AssignmentRepository@getLatestActiveAssignmentByCustomer: ' . $e->getMessage());
            throw new Exception('Error al obtener la última asignación activa del cliente.');
        }
    }

    public function getLocationsByCustomer(int $customerId): ?Assignment
    {
        try {
            $assignment = Assignment::where('customer_id', $customerId)
                                    ->where('status', StatusEnum::ACTIVE->value)
                                    ->with(['agent', 'customer'])
                                    ->first();
            if (!$assignment) {
                Log::warning("No se encontró ninguna asignación activa para el cliente ID: {$customerId}");
                return null;
            }
            return $assignment;
        } catch (Throwable $e) {
            Log::error("Error en getLocationsByCustomer (AssignmentRepository) para el cliente ID: {$customerId} - " . $e->getMessage());
            throw new Exception("Error al obtener la asignación del cliente.");
        }
    }
}
