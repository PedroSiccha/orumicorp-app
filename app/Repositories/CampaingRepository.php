<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Interfaces\CampaingRepositoryInterface;
use App\Models\Campaing;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class CampaingRepository implements CampaingRepositoryInterface
{
    public function getAllCampaings(): Collection
    {
        try {
            return Campaing::all();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener las campañas: " . $e->getMessage());
        }
    }
    public function getLastCampaingByCustomer(int $customerId): ?Campaing
    {
        try {
            return Campaing::where('customer_id', $customerId)->orderBy('created_at', 'desc')->first();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener la última campaña del cliente ID {$customerId}: " . $e->getMessage());
        }
    }
    public function getAllCampaingsByCustomer(int $customerId): Collection
    {
        try {
            return Campaing::where('customer_id', $customerId)->get();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener las campañas del cliente ID {$customerId}: " . $e->getMessage());
        }
    }

}
