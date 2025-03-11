<?php
namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Interfaces\CampaingRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CampaingService
{

    protected $campaignRepository;

    public function __construct(
        CampaingRepositoryInterface $campaignRepository
    ) {
        $this->campaignRepository = $campaignRepository;
    }

    public function getAllCampaignsByCustomer(int $customerId)
    {
        try {
            $campaigns = $this->campaignRepository->getCampaignsByCustomer($customerId);
            return ResponseHelper::success('Campañas obtenidas correctamente.', ['response' => $campaigns]);
        } catch (Exception $e) {
            Log::error("Error en getAllCampaignsByCustomer: " . $e->getMessage());
            return ResponseHelper::error('Error al obtener las campañas del cliente.');
        }
    }

    public function getLastCampaignByCustomer(int $customerId)
    {
        try {
            return ResponseHelper::success('Última campaña obtenida correctamente.', [
                'data' => $this->campaignRepository->getLastCampaignByCustomer($customerId)
            ]);
        } catch (Exception $e) {
            Log::error("Error en getLastCampaignByCustomer: " . $e->getMessage());
            return ResponseHelper::error('Error al obtener la última campaña.');
        }
    }

    public function saveCampaign(array $data)
    {
        DB::beginTransaction();
        try {
            $campaignData = [
                'name' => $data['name'],
                'description' => $data['description'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date']
            ];

            $this->campaignRepository->save($campaignData);
            DB::commit();

            return ResponseHelper::success('Campaña guardada correctamente.', [
                'response' => $this->campaignRepository->getActiveCampaigns()
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error de validación en saveCampaign: " . $e->getMessage());
            return ResponseHelper::error('Error en la validación de la campaña.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en saveCampaign: " . $e->getMessage());
            return ResponseHelper::error('Error al guardar la campaña.');
        }
    }

    public function getAllCampaigns()
    {
        try {
            return ResponseHelper::success('Campañas obtenidas correctamente.', [
                'response' => $this->campaignRepository->getAll()
            ]);
        } catch (Exception $e) {
            Log::error("Error en getAllCampaigns: " . $e->getMessage());
            return ResponseHelper::error('Error al obtener todas las campañas.');
        }
    }

    public function getCampaigns()
    {
        try {
            return ResponseHelper::success('Campañas obtenidas correctamente.', [
                'response' => $this->campaignRepository->getActiveCampaigns()
            ]);
        } catch (Exception $e) {
            Log::error("Error en getCampaigns: " . $e->getMessage());
            return ResponseHelper::error('Error al obtener las campañas.');
        }
    }

    public function updateCampaign(int $campaignId, array $data)
    {
        DB::beginTransaction();
        try {
            $campaign = $this->campaignRepository->findById($campaignId);
            if (!$campaign) return ResponseHelper::error('La campaña no existe.');

            $campaignData = [
                'name' => $data['name'],
                'description' => $data['description'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date']
            ];

            $this->campaignRepository->update($campaign, $campaignData);
            DB::commit();

            return ResponseHelper::success('Campaña actualizada correctamente.', [
                'response' => $this->campaignRepository->getActiveCampaigns()
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error de validación en updateCampaign: " . $e->getMessage());
            return ResponseHelper::error('Error en la validación de la campaña.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en updateCampaign: " . $e->getMessage());
            return ResponseHelper::error('Error al actualizar la campaña.');
        }
    }

    public function deleteCampaign(int $campaignId)
    {
        DB::beginTransaction();
        try {
            $campaign = $this->campaignRepository->findById($campaignId);
            if (!$campaign) return ResponseHelper::error('La campaña no existe.');

            $this->campaignRepository->delete($campaign->id);
            DB::commit();

            return ResponseHelper::success('Campaña eliminada correctamente.', [
                'response' => $this->campaignRepository->getActiveCampaigns()
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en deleteCampaign: " . $e->getMessage());
            return ResponseHelper::error('Error al eliminar la campaña.');
        }
    }

}
