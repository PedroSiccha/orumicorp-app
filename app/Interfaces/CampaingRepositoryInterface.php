<?php
namespace App\Interfaces;

use App\Http\Requests\EditCampaignRequest;
use App\Http\Requests\SaveCampaingRequest;
use App\Models\Campaing;
use Illuminate\Database\Eloquent\Collection;

interface CampaingRepositoryInterface
{
    public function getAllCampaings(): Collection;
    public function getCampaing(): Collection;
    public function findCampaingById(int $campaingId): ?Campaing;
    public function getLastCampaingByCustomer(int $customerId): ?Campaing;
    public function getAllCampaingsByCustomer(int $customerId): Collection;
    public function saveCampaing(SaveCampaingRequest $request): ?Campaing;
    public function updateCampaign(Campaing $campaing, SaveCampaingRequest $data): bool;
    public function deleteCampaign(Campaing $campaing): bool;
}
