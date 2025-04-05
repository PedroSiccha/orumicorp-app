<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Interfaces\CampaingRepositoryInterface;
use App\Models\Campaing;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class CampaingRepository implements CampaingRepositoryInterface
{
    public function getAll(): Collection
    {
        try {
            return Campaing::all();
        } catch (QueryException $e) {
            Log::error('CampaingRepository@getAll: ' . $e->getMessage());
            throw new Exception('Error al obtener campañas.');
        }
    }

    public function getLastCampaignByCustomer(int $customerId): ?Campaing
    {
        try {
            return Campaing::where('customer_id', $customerId)
                           ->orderBy('created_at', 'desc')
                           ->first();
        } catch (QueryException $e) {
            Log::error('CampaingRepository@getLastCampaignByCustomer: ' . $e->getMessage());
            throw new Exception('Error al obtener última campaña del cliente.');
        }
    }

    public function getCampaignsByCustomer(int $customerId): Collection
    {
        try {
            return Campaing::where('customer_id', $customerId)->get();
        } catch (QueryException $e) {
            Log::error('CampaingRepository@getCampaignsByCustomer: ' . $e->getMessage());
            throw new Exception('Error al obtener campañas del cliente.');
        }
    }

    public function findById(int $campaignId): ?Campaing
    {
        try {
            return Campaing::find($campaignId);
        } catch (QueryException $e) {
            Log::error('CampaingRepository@findById: ' . $e->getMessage());
            throw new Exception('Error al buscar campaña.');
        }
    }

    public function getActiveCampaigns(): Collection
    {
        try {
            return Campaing::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error('CampaingRepository@getActiveCampaigns: ' . $e->getMessage());
            throw new Exception('Error al obtener campañas activas.');
        }
    }

    public function save(array $data): Campaing
    {
        try {
            return Campaing::create($data);
        } catch (QueryException $e) {
            Log::error('CampaingRepository@save: ' . $e->getMessage());
            throw new Exception('Error al crear campaña.');
        }
    }

    public function update(Campaing $campaign, array $data): bool
    {
        try {
            return $campaign->update($data);
        } catch (QueryException $e) {
            Log::error('CampaingRepository@update: ' . $e->getMessage());
            throw new Exception('Error al actualizar campaña.');
        }
    }

    public function delete(int $campaignId): bool
    {
        try {
            $campaign = Campaing::find($campaignId);
            if (!$campaign) {
                return false;
            }
            return $campaign->delete();
        } catch (QueryException $e) {
            Log::error('CampaingRepository@delete: ' . $e->getMessage());
            throw new Exception('Error al eliminar campaña.');
        }
    }
}
