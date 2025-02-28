<?php
namespace App\Interfaces;

use App\Http\Requests\CampaignRequest;
use App\Models\Campaing;
use Illuminate\Database\Eloquent\Collection;

interface CampaingRepositoryInterface
{
    public function getAllCampaings(): Collection;
    public function getCampaing(): Collection;
    public function getLastCampaingByCustomer(int $customerId): ?Campaing;
    public function getAllCampaingsByCustomer(int $customerId): Collection;
    public function saveCampaing(SaveCampaingRequest $request): ?Campaing;
    public function updateCampaign(int $campaingId, CampaignRequest $request): Campaing;
    public function deleteCampaign(int $campaingId): ?Campaing;

}
