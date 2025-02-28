<?php
namespace App\Interfaces;

use App\Models\Area;
use App\Models\Percent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface PercentRepositoryInterface
{
    public function getPercents(): Collection;
    // public function getAllAreas(): Collection;
    // public function saveArea(AreaRequest $request): Area;
    // public function getAreas(): Collection;
}
