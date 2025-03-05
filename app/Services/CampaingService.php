<?php
namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Http\Requests\SaveCampaingRequest;
use App\Interfaces\CampaingRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CampaingService
{

    protected $campaingRepository;

    public function __construct(
        CampaingRepositoryInterface $campaingRepository
    ) {
        $this->campaingRepository = $campaingRepository;
    }

    public function getAllCampaingsByCustomer($request) {
        try {
            $campaings = $this->campaingRepository->getAllCampaingsByCustomer($request->clientId);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $campaings]);
        } catch (Exception $e) {  
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function getLastCampaingByCustomer($request) {
        try {
            $customerId = $request['customer_id'];

            $lastCampaing = $this->campaingRepository->getLastCampaingByCustomer($customerId); 
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
            $dataCamaping = new SaveCampaingRequest([
                'name' => $request->name,
                'description' => $request->description,
                'start_date' => $request->startDate,
                'end_date' => $request->endDate
            ]);
            $response = $this->campaingRepository->saveCampaing($dataCamaping);
            DB::commit();
            $campaigns = $this->campaingRepository->getCampaing();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $campaigns]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function getAllCampaigns()
    {
        try {
            $campaigns = $this->campaingRepository->getAllCampaings();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $campaigns]);
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function getCampaigns()
    {
        try {
            $campaigns = $this->campaingRepository->getCampaing();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $campaigns]);
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function updateCampaign($request)
    {
        DB::beginTransaction();
        try {
            $campaign = $this->campaingRepository->findCampaingById($request->id);
            $dataCamaping = new SaveCampaingRequest([
                'name' => $request->name,
                'description' => $request->description,
                'start_date' => $request->startDate,
                'end_date' => $request->endDate
            ]);
            $data = $this->campaingRepository->updateCampaign($campaign, $dataCamaping);
            DB::commit();
            $campaigns = $this->campaingRepository->getCampaing();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $campaigns]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function deleteCampaign($request)
    {
        DB::beginTransaction();
        try {
            $campaign = $this->campaingRepository->findCampaingById($request->id);
            $data = $this->campaingRepository->deleteCampaign($campaign);
            DB::commit();
            $campaigns = $this->campaingRepository->getCampaing();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $campaigns]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

}
