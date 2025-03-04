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
            $lastAssignment = $this->assignamentRepository->getLastAssignamentByCustomer($customerId);
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
