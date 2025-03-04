<?php
namespace App\Interfaces;

use App\Models\Area;
use App\Models\Percent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface PercentRepositoryInterface
{
    public function getPercents(): Collection;
}
