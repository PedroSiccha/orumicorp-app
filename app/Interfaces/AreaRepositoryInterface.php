<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface AreaRepositoryInterface
{
    public function getAllAreas(): Collection;
}
