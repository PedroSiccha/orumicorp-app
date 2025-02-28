<?php
namespace App\Services;

use App\Interfaces\AssignamentInterface;
use App\Models\Assignment;
use App\Repositories\Contracts\AssignmentRepositoryInterface;
use Exception;

class AssignamentService /*implements AssignamentInterface */
{

    protected $assignamentRepository;

    public function __construct(
        AssignmentRepositoryInterface $assignamentRepository
    ) {
        $this->assignamentRepository = $assignamentRepository;
    }

    public function getLastAssignamentByCustomer(int $customerId) {
        try {
            // $customerId = $request['customer_id'];

            $lastAssignment = $this->assignamentRepository->getLastAssignamentByCustomer($customerId); // Assignment::with(['agent', 'assignedBy'])->where('customer_id', $customerId)->where('status', 1)->orderBy('status', 'asc')->first();

            if ($lastAssignment) {
                return $lastAssignment;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

}
