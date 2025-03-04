<?php
namespace App\Repositories;

use App\Enums\MovementType;
use App\Enums\StatusEnum;
use App\Http\Requests\EditSalesRepository;
use App\Http\Requests\StoreSalesRequest;
use App\Interfaces\SalesRepositoryInterface;
use App\Models\Agent;
use App\Models\Area;
use App\Models\Sales;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesRepository implements SalesRepositoryInterface
{
    public function getBonusAgent(Agent $agent, array $actions, string $rol): Collection
    {
        try {
            $query = Sales::whereIn('action_id', $actions)->where('status', StatusEnum::ACTIVE->value)->orderBy('created_at', 'DESC')->with('action');

            if ($rol !== 'ADMINISTRADOR') {
              $query->where('agent_id', $agent->id);
            }

            return $query->get();
        } catch (QueryException $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getAmountIngreso(): Collection
    {
        try {
            return DB::table('sales as s')
                        ->join('actions as a', 's.action_id', '=', 'a.id')
                        ->join('movement_types as m', 'a.movement_type_id', '=', 'm.id')
                        ->where('m.name', MovementType::INGRESOS->value)
                        ->where('s.status', StatusEnum::ACTIVE->value)
                        ->where('a.status', StatusEnum::ACTIVE->value)
                        ->whereMonth('s.date_admission', date("m"))
                        ->value(DB::raw('COALESCE(SUM(s.amount), 0)'));
        } catch (QueryException $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getAmountEgreso(): Collection
    {
        try {
            return DB::table('sales as s')
                        ->join('actions as a', 's.action_id', '=', 'a.id')
                        ->join('movement_types as m', 'a.movement_type_id', '=', 'm.id')
                        ->where('m.name', MovementType::EGRESOS->value)
                        ->where('s.status', StatusEnum::ACTIVE->value)
                        ->where('a.status', StatusEnum::ACTIVE->value)
                        ->whereMonth('s.date_admission', date("m"))
                        ->value(DB::raw('COALESCE(SUM(s.amount), 0)'));
        } catch (QueryException $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getSales(): Collection
    {
        try {
             return Sales::where('status', StatusEnum::ACTIVE->value)->whereHas('agent')->whereHas('customer')->with(['agent', 'customer'])->get();
        } catch (QueryException $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveSale(StoreSalesRequest $data): Sales
    {
        try {
            return Sales::create($data);
        } catch (QueryException $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function searchBonusAgent(string $code, string $name, Area $area, string $dateInit, string $dateEnd): ?Sales
    {
        try {
            return Sales::join('agents as a', 'sales.agent_id', '=', 'a.id')
                        ->where(function ($queryAction) {
                            $queryAction->where('sales.action_id', 2)->orWhere('sales.action_id', 3);
                        })
                        ->where(function ($query) use ($code, $name) {
                            $query->where('a.code', 'LIKE', '%' . $code . '%')
                                ->orWhere(DB::raw("CONCAT(a.name, ' ', a.lastname)"), 'LIKE', '%' . $name . '%');
                        })
                        ->where('a.area_id', $area->id)
                        ->whereBetween('sales.date_admission', [$dateInit, $dateEnd])
                        ->get();
        } catch (QueryException $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getSalesByActionBetweenDate(int $actionId, string $dateNow, string $monthNow, string $rol, ?Agent $agent = null): Collection
    {
        try {
                $query = Sales::join('agents as a', 'sales.agent_id', '=', 'a.id')
                                ->selectRaw('a.name, a.lastname,
                                            SUM(CASE WHEN sales.action_id = ? THEN sales.amount ELSE 0 END) AS total_amount_action,
                                            SUM(CASE WHEN DATE(sales.created_at) = ? THEN sales.amount ELSE 0 END) AS total_amount_day,
                                            SUM(CASE WHEN DATE_FORMAT(sales.created_at, "%Y-%m") = ? THEN sales.amount ELSE 0 END) AS total_amount_month', 
                                            [$actionId, $dateNow, $monthNow])
                                ->addSelect(DB::raw('(SELECT COUNT(*) FROM sales WHERE DATE(sales.created_at) = ? AND sales.agent_id = a.id) AS total_sales_day'), 
                                            [$dateNow])
                                ->addSelect(DB::raw('(SELECT COUNT(*) FROM sales WHERE DATE_FORMAT(sales.created_at, "%Y-%m") = ? AND sales.agent_id = a.id) AS total_sales_month'), 
                                            [$monthNow])
                                ->groupBy('a.id')
                                ->orderBy('total_amount_day', 'DESC');
                if ($rol !== 'ADMINISTRADOR' && $agent) {
                    $query->where('sales.agent_id', $agent->id);
                }
                return $query->get();
        } catch (QueryException $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getSalesByActionAdmission(int $actionId, string $rol, string $monthNow, string $yearNow, string $previousMonth, string $previousYear, ?Agent $agent = null): Collection
    {
        try {
            $query = Sales::where('status', true)
                            ->where('action_id', $actionId)
                            ->where(function ($query) use ($monthNow, $yearNow, $previousMonth, $previousYear) {
                                $query->whereYear('date_admission', $yearNow)->whereMonth('date_admission', $monthNow)
                                        ->orWhere(function ($query) use ($previousMonth, $previousYear) {
                                            $query->whereYear('date_admission', $previousYear)->whereMonth('date_admission', $previousMonth);
                                        });
                            })
                            ->orderBy('date_admission', 'desc')
                            ->get();
            if ($rol !== 'ADMINISTRADOR' && $agent) {
                $query->where('agent_id', $agent->id);
            }
            return $query->get();
        } catch (QueryException $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function filterSalesByDate(string $code, int $areaId, Carbon $dateInit, Carbon $dateEnd)
    {
        try {
            return Sales::whereHas('agent', function ($query) use ($code, $areaId) {
                    if (!empty($areaId)) {
                        $query->where('area_id', $areaId);
                    }
                    if (!empty($code)) {
                        $query->where(function ($q) use ($code) {
                            $q->where('code_voiso', $code)
                                ->orWhere('name', 'LIKE', "%$code%")
                                ->orWhere('lastname', 'LIKE', "%$code%");
                        });
                    }
                })
                ->whereDate('date_admission', '>=', $dateInit->toDateTimeString())
                ->whereDate('date_admission', '<=', $dateEnd->toDateTimeString())
                ->with(['agent', 'customer'])
                ->get();
        } catch (QueryException $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function updateSale(Sales $sale, EditSalesRepository $data): bool
    {
        try {
            $sale->fill($data->validate());
            if (!$sale->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            return false;
        }
    }

    public function getBonusAction(array $data): Collection
    {
        try {
            return Sales::where('status', StatusEnum::ACTIVE->value)
                            ->whereIn('action_id', $data)
                            ->orderBy('created_at', 'desc')
                            ->get();
        } catch (QueryException $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getSalesByAgent(int $agentId, int $pagination): Collection
    {
        try {
            return Sales::select('sales.*', 'c.name', 'c.lastname')
                        ->join('customers as c', 'sales.customer_id', '=', 'c.id')
                        ->where('sales.agent_id', $agentId)
                        ->paginate($pagination, ['*'], 'sales_page')->withQueryString();

        } catch (QueryException $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getAmountDateByAgent(Agent $agent, MovementType $movementType): float
    {
        try {
            return Sales::join('actions', 'sales.action_id', '=', 'actions.id')
                                    ->where('actions.movement_type_id', $movementType->value)
                                    ->where('actions.status', StatusEnum::ACTIVE->value)
                                    ->where('sales.status', StatusEnum::ACTIVE->value)
                                    ->where('sales.agent_id', $agent->id)
                                    ->whereMonth('sales.created_at', date("m"))
                                    ->sum('sales.amount');
        } catch (QueryException $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getAmountByArea(int $areaId): float
    {
        try {
             return Sales::join('agents', 'sales.agent_id', '=', 'agents.id')
                            ->where('agents.area_id', $areaId)
                            ->sum('sales.amount');
        } catch (QueryException $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getAmountBySales(int $pagination): Collection
    {
        try {
             return Sales::selectRaw('SUM(sales.amount) AS monto, agents.name, agents.lastname, areas.name AS area')
                                ->join('agents', 'sales.agent_id', '=', 'agents.id')
                                ->join('areas', 'agents.area_id', '=', 'areas.id')
                                ->groupBy('agents.id')
                                ->orderBy('monto', 'desc')
                                ->take($pagination)
                                ->get();
        } catch (QueryException $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error SalesRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }
}
