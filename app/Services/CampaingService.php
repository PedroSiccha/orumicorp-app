<?php
namespace App\Services;

use App\Interfaces\CampaingInterface;
use App\Models\CampaignCustomer;
use App\Models\Campaing;
use App\Models\Customers;
use Exception;

class CampaingService implements CampaingInterface {
    public function __construct()
    {}

    public function getAllCampaingsByCustomer($request) {
        try {
            $customerId = $request['customer_id'];
            $campaings = Campaing::get();
            return $campaings;
        } catch (Exception $e) {
            dd($e);
            return collect();
        }

    }

    public function getLastCampaingByCustomer($request) {
        try {
            $customerId = $request['customer_id'];

            $lastCampaing = Campaing::whereHas('customers', function($query) use ($customerId) {
                $query->where('customer_id', $customerId);
            })->with('customers')->orderBy('created_at', 'desc')->first();

            return response()->json([
                'status' => 'success',
                'data' => $lastCampaing,
            ]);
        } catch (Exception $e) {
            return null;
        }
    }

}
