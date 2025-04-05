<?php
namespace App\Services;

use App\Repositories\Contracts\AssignmentRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class AssignamentService
{

    protected $assignmentRepository;

    public function __construct(
        AssignmentRepositoryInterface $assignmentRepository
    ) {
        $this->assignmentRepository = $assignmentRepository;
    }

    public function getLastAssignmentByCustomer(int $customerId)
    {
        try {
<<<<<<< HEAD
            $customerId = $request['customer_id'];

            $lastAssignment = Assignment::with(['agent', 'assignedBy'])->where('customer_id', $customerId)->where('status', 1)->orderBy('date', 'DESC')->first();

            if ($lastAssignment) {
                return $lastAssignment;
            } else {
                return null;
            }
        } catch (\Exception $e) {
=======
            return $this->assignmentRepository->getLatestActiveAssignmentByCustomer($customerId);
        } catch (Exception $e) {
            Log::error("Error en getLastAssignmentByCustomer: " . $e->getMessage());
>>>>>>> feature/fix-presentation
            return null;
        }
    }

}
