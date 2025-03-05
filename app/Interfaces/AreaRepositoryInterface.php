<?php
namespace App\Interfaces;

use App\Http\Requests\AreaRequest;
use App\Http\Requests\SaveAreaRequest;
use App\Http\Requests\StoreareaRequest;
use App\Http\Requests\UpdateareaRequest;
use App\Models\Area;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface AreaRepositoryInterface
{
    public function getAllAreas(): Collection;
    public function saveArea(StoreareaRequest $request): Area;
    public function getAreas(): Collection;
    public function updateArea(Area $area, StoreareaRequest $data): bool;
    public function getAreaById(int $areaId): ?Area;
    public function changeStatusArea(Area $areaId, bool $status): bool;
    public function deleteArea(int $areaId): bool;
}