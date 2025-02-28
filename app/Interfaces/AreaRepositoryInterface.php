<?php
namespace App\Interfaces;

use App\Http\Requests\AreaRequest;
use App\Models\Area;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface AreaRepositoryInterface
{
    public function getAllAreas(): Collection;
    public function saveArea(AreaRequest $request): Area;
    public function getAreas(): Collection;
    public function updateArea(int $areaId, UpdateAreaRequest $data): Area;
    public function getAreaById(int $areaId): ?Area;
    public function changeStatusArea(int $areaId, bool $status): ?Area;
    public function deleteArea(Area $area): bool;
}
