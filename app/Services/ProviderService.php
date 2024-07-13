<?php
namespace App\Services;

use App\Interfaces\ProviderInterface;
use App\Models\Provider;
use Exception;

class ProviderService implements ProviderInterface {

    public function __construct(){}

    public function getAllProvidersByCustomer($request) {
        try {
            $customerId = $request['customer_id'];
            $providers = Provider::whereHas('customers', function($query) use ($customerId) {
                $query->where('customer_id', $customerId);
            })->with('customers')->get();
            return response()->json([
                'status' => 'success',
                'data' => $providers,
            ]);
        } catch (Exception $e) {
            return collect();
        }
    }

    public function getLastProviderByCustomer($request) {
        try {
            $customerId = $request['customer_id'];
            $lastProvider = Provider::whereHas('customers', function($query) use ($customerId) {
                $query->where('customer_id', $customerId);
            })->with('customers')->orderBy('created_at', 'desc')->first();

            return response()->json([
                'status' => 'success',
                'data' => $lastProvider
            ]);
        } catch (Exception $e) {
            return null;
        }
    }

}
