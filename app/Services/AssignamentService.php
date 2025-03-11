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
            return $this->assignmentRepository->getLatestActiveAssignmentByCustomer($customerId);
        } catch (Exception $e) {
            Log::error("Error en getLastAssignmentByCustomer: " . $e->getMessage());
            return null;
        }
    }

}
