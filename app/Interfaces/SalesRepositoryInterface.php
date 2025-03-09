<?php
namespace App\Interfaces;

use App\Enums\MovementType;
use App\Http\Requests\EditSalesRepository;
use App\Http\Requests\StoreSalesRequest;
use App\Models\Agent;
use App\Models\Area;
use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Ramsey\Uuid\Type\Decimal;
use Spatie\Permission\Models\Role;

interface SalesRepositoryInterface
{
    public function getBonusAgent(Agent $agent, array $actions, string $rol): Collection;
    public function getAmountIngreso(): Collection;
    public function getAmountEgreso(): Collection;
    public function getSales(): Collection;
    public function saveSale(StoreSalesRequest $data): Sales;
    public function searchBonusAgent(string $code, string $name, Area $area, string $dateInit, string $dateEnd): ?Sales;
    public function getSalesByActionBetweenDate(int $actionId, string $dateNow, string $monthNow, string $rol, ?Agent $agent = null): Collection;
    public function getSalesByActionAdmission(int $actionId, string $rol, string $monthNow, string $yearNow, string $previousMonth, string $previousYear, ?Agent $agent = null): Collection;
    public function filterSalesByDate(string $code, int $areaId, Carbon $dateInit, Carbon $dateEnd);
    public function updateSale(Sales $sale, StoreSalesRequest $data): bool;
    public function getBonusAction(array $data): Collection;
    public function getSalesByAgent(int $agentId, int $pagination): Collection;
    public function getAmountDateByAgent(Agent $agent, MovementType $movementType): float; //El $movementType se tratará como $valor = $movementType->value;
    public function getAmountByArea(int $areaId): float;
    public function getAmountBySales(int $pagination): Collection;
    public function findSaleById(int $saleId): ?Sales;
}
