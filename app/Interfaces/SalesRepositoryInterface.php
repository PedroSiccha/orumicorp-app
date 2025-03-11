<?php
namespace App\Interfaces;

use App\Enums\MovementType;
use App\Models\Agent;
use App\Models\Area;
use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface SalesRepositoryInterface
{
    public function getBonusAgent(array $actions, bool $status, string $order, ?Agent $agent = null, ?string $rol = null): Collection;
    public function getAmountIngreso(): float;
    public function getAmountEgreso(): float;
    public function getSales(): Collection;
    public function saveSale(array $data): Sales;
    public function getSalesByAgent(int $agentId, int $pagination): LengthAwarePaginator;
    public function findSaleById(int $saleId): ?Sales;
    public function getAmountBySales(int $limit): Collection;
    public function updateSale(Sales $sale, array $data): bool;
    public function searchBonusAgent(string $code, string $name, Area $area, string $dateInit, string $dateEnd): Collection;
    public function getSalesByActionBetweenDate(int $actionId, string $dateNow, string $monthNow, string $rol, ?Agent $agent = null): Collection;
    public function getSalesByActionAdmission(int $actionId, string $rol, string $monthNow, string $yearNow, string $previousMonth, string $previousYear, ?Agent $agent = null): Collection;
    public function filterSalesByDate(string $code, int $areaId, Carbon $dateInit, Carbon $dateEnd): Collection;
    public function getBonusAction(array $actions): Collection;
    public function getAmountDateByAgent(Agent $agent, MovementType $movementType): float;
    public function getAmountByArea(int $areaId): float;
}
