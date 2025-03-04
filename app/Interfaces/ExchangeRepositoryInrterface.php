<?php
namespace App\Interfaces;

use App\Models\Area;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ExchangeRepositoryInrterface
{
    public function getExchangeRates(): Collection;
}
