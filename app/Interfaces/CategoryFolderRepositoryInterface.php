<?php
namespace App\Interfaces;

use App\Http\Requests\CampaignRequest;
use App\Models\Campaing;
use App\Models\CategoryFolder;
use Illuminate\Database\Eloquent\Collection;

interface CategoryFolderRepositoryInterface
{
    public function getAllCategoryFolders(): Collection;
    public function getCategoryFolders(): Collection;
    // public function getLastCampaingByCustomer(int $customerId): ?Campaing;
    // public function getAllCampaingsByCustomer(int $customerId): Collection;
    public function saveCategoryFolder(SaveCategoryFolderRequest $request): ?CategoryFolder;
    // public function updateCampaign(int $campaingId, CampaignRequest $request): Campaing;
    // public function deleteCampaign(int $campaingId): ?Campaing;

}
