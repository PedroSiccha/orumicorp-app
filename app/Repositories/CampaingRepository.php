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
}
