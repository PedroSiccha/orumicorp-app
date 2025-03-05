<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Http\Requests\EditCampaignRequest;
use App\Http\Requests\SaveCampaingRequest;
use App\Interfaces\CampaingRepositoryInterface;
use App\Models\Campaing;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class CampaingRepository implements CampaingRepositoryInterface
{

    public function getAllCampaings(): Collection
    {
        try {
            return Campaing::all();
        } catch (QueryException $e) {
            Log::error("Error CampaingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error CampaingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getLastCampaingByCustomer(int $customerId): ?Campaing
    {
        try {
            return Campaing::where('customer_id', $customerId)->orderBy('created_at', 'desc')->first();
        } catch (QueryException $e) {
            Log::error("Error CampaingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error CampaingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getAllCampaingsByCustomer(int $customerId): Collection
    {
        try {
            return Campaing::where('customer_id', $customerId)->get();
        } catch (QueryException $e) {
            Log::error("Error CampaingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error CampaingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function findCampaingById(int $campaingId): ?Campaing
    {
        try {
            return Campaing::find($campaingId);
        } catch (QueryException $e) {
            Log::error("Error CampaingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error CampaingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getCampaing(): Collection
    {
        try {
            return Campaing::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error("Error CampaingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error CampaingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveCampaing(SaveCampaingRequest $data): ?Campaing
    {
        try {
            return Campaing::create($data);
        } catch (QueryException $e) {
            Log::error("Error CampaingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error CampaingRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function updateCampaign(Campaing $campaing, SaveCampaingRequest $data): bool
    {
        try {
            $campaing->fill($data->validated());
            if (!$campaing->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error CampaingRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error CampaingRepository: " . $e->getMessage());
            return false;
        }
    }

    public function deleteCampaign(Campaing $campaing): bool
    {
        try {
            if (!$campaing->delete()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error CampaingRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error CampaingRepository: " . $e->getMessage());
            return false;
        }
    }

}
