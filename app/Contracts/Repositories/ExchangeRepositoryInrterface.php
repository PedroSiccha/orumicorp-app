<?php
namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface ExchangeRepositoryInrterface
{
    public function getActiveExchangeRates(): Collection;
    public function getAllExchangeRates(): Collection;
}
