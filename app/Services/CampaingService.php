<?php
namespace App\Services;

use App\Interfaces\CampaingInterface;
use App\Models\CampaignCustomer;
use App\Models\Campaing;
use App\Models\Customers;
use Exception;
use Illuminate\Support\Facades\DB;

class CampaingService implements CampaingInterface {
    public function __construct()
    {}

    public function getAllCampaingsByCustomer($request) {
        try {
            $customerId = $request['customer_id'];
            $campaings = $this->campaingRepository->getCampaing(); // Campaing::get();
            return $campaings;
        } catch (Exception $e) {
            dd($e);
            return collect();
        }

    }

    public function getLastCampaingByCustomer($request) {
        try {
            $customerId = $request['customer_id'];

            $lastCampaing = $this->campaingRepository->getLastCampaingByClient(); 
            //  Campaing::whereHas('customers', function($query) use ($customerId) {
            //     $query->where('customer_id', $customerId);
            // })->with('customers')->orderBy('created_at', 'desc')->first();

            return response()->json([
                'status' => 'success',
                'data' => $lastCampaing,
            ]);
        } catch (Exception $e) {
            return null;
        }
    }

    public function saveCampaing($request) {

        DB::beginTransaction();
        try {
            $response = $this->campaingRepository->saveCampaing($request);
            DB::commit();

            // $campaign = new Campaing();
            // $campaign->name = $request->name;
            // $campaign->description = $request->description;
            // $campaign->start_date = $request->startDate;
            // $campaign->end_date = $request->endDate;
            // if ($campaign->save()) {
            //     $title = "Correcto";
            //     $mensaje = "Su campaña se registró correctamente";
            //     $status = "success";
            // }

        } catch (ValidationException $e) {
            DB::rollBack();
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        } catch (Exception $e) {
            DB::rollBack();
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        $campaigns = $this->campaingRepository->getCampaing(); // Campaing::get();
    }

}
