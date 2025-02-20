<?php
namespace App\Interfaces;

use App\Models\Campaing;
use Illuminate\Database\Eloquent\Collection;

interface CampaingRepositoryInterface
{
    public function getAllCampaings(): Collection;
    public function getLastCampaingByCustomer(int $customerId): ?Campaing;
    public function getAllCampaingsByCustomer(int $customerId): Collection;
}
