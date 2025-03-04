<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Models\Assignment;
use App\Repositories\Contracts\AssignmentRepositoryInterface;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssignmentRepository implements AssignmentRepositoryInterface
{
    public function getActiveAssignments(int $customerId): Collection
    {
        try {
            return Assignment::where('customer_id', $customerId)
                            ->where('status', StatusEnum::ACTIVE->value)
                            ->get();
        } catch (QueryException $e) {
            Log::error("Error AssignmentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AssignmentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }

    }

    public function desactivateAssignments(Collection $assignments): void
    {
        try {
            foreach ($assignments as $assignment) {
                $assignment->status = 0;
                $assignment->save();
            }
        } catch (QueryException $e) {
            Log::error("Error AssignmentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AssignmentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }

    }

    public function createAssignment(array $data): Assignment
    {
        try {
            return Assignment::create($data);
        } catch (QueryException $e) {
            Log::error("Error AssignmentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AssignmentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function createAssignments(array $assignments): void
    {
        try {
            DB::table('assignments')->insert($assignments);
        } catch (QueryException $e) {
            Log::error("Error AssignmentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AssignmentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
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
            } catch (QueryException $e) {
                Log::error("Error AssignmentRepository: " . $e->getMessage());
                throw new Exception("No se encontraron resultados para los filtros aplicados.");
            } catch (Exception $e) {
                Log::error("Error AssignmentRepository: " . $e->getMessage());
                throw new Exception("No se encontraron resultados para los filtros aplicados.");
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
        } catch (QueryException $e) {
            Log::error("Error AssignmentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AssignmentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getLastAssignamentByCustomer(int $customerId): ?Assignment
    {
        try {
            return Assignment::with(['agent', 'assignedBy'])
                             ->where('customer_id', $customerId)
                             ->where('status', StatusEnum::ACTIVE->value)
                             ->orderBy('status', 'asc')
                             ->first();
        } catch (QueryException $e) {
            Log::error("Error AssignmentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AssignmentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }
}
