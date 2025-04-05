<?php
namespace App\Interfaces;

use App\Models\Campaing;
use Illuminate\Database\Eloquent\Collection;

interface CampaingRepositoryInterface
{
    public function getAll(): Collection;
    public function getLastCampaignByCustomer(int $customerId): ?Campaing;
    public function getCampaignsByCustomer(int $customerId): Collection;
    public function findById(int $campaignId): ?Campaing;
    public function getActiveCampaigns(): Collection;
    public function save(array $data): Campaing;
    public function update(Campaing $campaign, array $data): bool;
    public function delete(int $campaignId): bool;
}
