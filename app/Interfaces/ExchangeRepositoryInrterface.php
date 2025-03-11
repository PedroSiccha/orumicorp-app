<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ExchangeRepositoryInrterface
{
    public function getActiveExchangeRates(): Collection;
    public function getAllExchangeRates(): Collection;
}
