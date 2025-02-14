<?php
namespace App\Services;

use App\Interfaces\AssignamentInterface;
use App\Models\Assignment;

class AssignamentService implements AssignamentInterface {

    public function __construct()
    {}

    public function getLastAssignamentByCustomer($request) {
        try {
            $customerId = $request['customer_id'];

            $lastAssignment = Assignment::with(['agent', 'assignedBy'])->where('customer_id', $customerId)->where('status', 1)->orderBy('status', 'asc')->first();

            if ($lastAssignment) {
                return $lastAssignment;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

}
