<?php
namespace App\Interfaces;

use App\Http\Requests\CampaignRequest;
use App\Http\Requests\SaveCategoryFolderRequest;
use App\Models\Campaing;
use App\Models\CategoryFolder;
use Illuminate\Database\Eloquent\Collection;

interface CategoryFolderRepositoryInterface
{
    public function getAllCategoryFolders(): Collection;
    public function getCategoryFolders(): Collection;
    public function saveCategoryFolder(SaveCategoryFolderRequest $request): ?CategoryFolder;
}
