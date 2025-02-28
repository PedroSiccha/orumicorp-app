<?php
namespace App\Interfaces;

use App\Models\Area;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Ramsey\Uuid\Type\Decimal;

interface TargetRepositoryInterface
{
    public function getTargets(): Collection;
    public function getSumAmount($target): ?Decimal;
    // public function getAreas(): Collection;
}
