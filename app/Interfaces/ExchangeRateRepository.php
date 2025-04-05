<?php
namespace App\Interfaces;

use App\Models\Agent;
use App\Models\Area;
use App\Models\Sales;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

interface ExchangeRateRepository
{
    public function getExchangesRate(): Collection;
}
