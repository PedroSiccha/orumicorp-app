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

            // dd($lastAssignment);

            // $lastAssignment = Assignment::where('customer_id', $customerId)
            // ->with(['agent', 'assignedBy'])
            // ->orderBy('date', 'desc')
            // ->first();

            if ($lastAssignment) {
                return $lastAssignment;
                // return response()->json([
                //     'status' => 'success',
                //     'data' => $lastAssignment,
                // ]);
            } else {
                return null;
                // return response()->json([
                //     'status' => 'error',
                //     'message' => 'No assignments found for this customer',
                // ]);
            }
        } catch (\Exception $e) {
            return null;
            // return response()->json([
            //     'status' => 'error',
            //     'message' => $e->getMessage(),
            // ], 500);
        }
    }

}
