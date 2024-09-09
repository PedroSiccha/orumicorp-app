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
            $lastAssignment = Assignment::where('customer_id', $customerId)
            ->with(['agent', 'assignedBy'])
            ->orderBy('date', 'desc')
            ->first();

            if ($lastAssignment) {
                return response()->json([
                    'status' => 'success',
                    'data' => $lastAssignment,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No assignments found for this customer',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
