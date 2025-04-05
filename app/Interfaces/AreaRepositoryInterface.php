<?php
namespace App\Interfaces;

use App\Models\Area;
use Illuminate\Database\Eloquent\Collection;

interface AreaRepositoryInterface
{
    public function getAll(): Collection;
    public function getAllActive(): Collection;
    public function save(array $data): Area;
    public function update(Area $area, array $data): bool;
    public function findById(int $areaId): ?Area;
    public function changeStatus(int $areaId, bool $status): bool;
    public function delete(int $areaId): bool;
}