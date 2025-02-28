<?php
namespace App\Interfaces;

use App\Models\Agent;
use App\Models\Area;
use App\Models\Sales;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

interface SalesRepositoryInterface
{
    public function getBonusAgent(Agent $agent, array $roles): Collection;
    public function getAmountIngreso(): ?Sales;
    public function getAmountEgreso(): ?Sales;
    public function getSales(): Collection;
    public function saveSale(SaveSalesRequest $request): Sales;
    public function searchBonusAgent(): ?Sales;
}
