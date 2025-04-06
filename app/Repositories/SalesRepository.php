<?php
namespace App\Repositories;

use App\Contracts\Repositories\SalesRepositoryInterface;
use App\Enums\MovementType;
use App\Enums\StatusEnum;
use App\Models\Agent;
use App\Models\Area;
use App\Models\Sales;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class SalesRepository implements SalesRepositoryInterface
{

    public function obtenerTotalesPorMesYArea(int $year)
    {
        return DB::table(DB::raw('
                        (SELECT 1 AS mes UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 
                        UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12) meses
                    '))
                    ->crossJoin('areas')
                    ->leftJoin(DB::raw("
                        (SELECT MONTH(date_admission) AS mes, agents.area_id, SUM(amount) AS amount
                        FROM sales
                        INNER JOIN agents ON sales.agent_id = agents.id
                        WHERE YEAR(date_admission) = {$year}
                        GROUP BY mes, agents.area_id
                        ) sales
                    "), function ($join) {
                        $join->on('meses.mes', '=', 'sales.mes')
                            ->on('areas.id', '=', 'sales.area_id');
                    })
                    ->select(
                        'meses.mes as mes',
                        'areas.name as area',
                        DB::raw('COALESCE(SUM(sales.amount), 0) AS total_ventas')
                    )
                    ->groupBy('meses.mes', 'areas.name')
                    ->orderBy('meses.mes')
                    ->orderBy('areas.name')
                    ->get();
    }

    // public function getBonusAgent(array $actions, bool $status, string $order, ?Agent $agent = null, ?string $rol = null): Collection
    // {
    //     try {
    //         $query = Sales::whereIn('action_id', $actions)
    //             ->where('status', $status)
    //             ->orderBy('date_admission', $order)
    //             ->with('action');
    //         if ($rol !== 'ADMINISTRADOR' && $agent) {
    //             $query->where('agent_id', $agent->id);
    //         }
    //         return $query->get();
    //     } catch (Throwable $e) {
    //         Log::error("Error en SalesRepository@getBonusAgent: " . $e->getMessage());
    //         throw new Exception("Error al obtener bonos de agentes.");
    //     }
    // }

    // public function getAmountIngreso(): float
    // {
    //     try {
    //         return (float) DB::table('sales as s')
    //             ->join('actions as a', 's.action_id', '=', 'a.id')
    //             ->join('movement_types as m', 'a.movement_type_id', '=', 'm.id')
    //             ->where('m.name', MovementType::INGRESOS->value)
    //             ->where('s.status', StatusEnum::ACTIVE->value)
    //             ->where('a.status', StatusEnum::ACTIVE->value)
    //             ->whereMonth('s.date_admission', date("m"))
    //             ->sum('s.amount');
    //     } catch (Throwable $e) {
    //         Log::error("Error en SalesRepository@getAmountIngreso: " . $e->getMessage());
    //         throw new Exception("Error al obtener el monto de ingresos.");
    //     }
    // }

    // public function getAmountEgreso(): float
    // {
    //     try {
    //         return (float) DB::table('sales as s')
    //             ->join('actions as a', 's.action_id', '=', 'a.id')
    //             ->join('movement_types as m', 'a.movement_type_id', '=', 'm.id')
    //             ->where('m.name', MovementType::EGRESOS->value)
    //             ->where('s.status', StatusEnum::ACTIVE->value)
    //             ->where('a.status', StatusEnum::ACTIVE->value)
    //             ->whereMonth('s.date_admission', date("m"))
    //             ->sum('s.amount');
    //     } catch (Throwable $e) {
    //         Log::error("Error en SalesRepository@getAmountEgreso: " . $e->getMessage());
    //         throw new Exception("Error al obtener el monto de egresos.");
    //     }
    // }

    // public function getSales(): Collection
    // {
    //     try {
    //         return Sales::with(['agent', 'customer'])
    //             ->where('status', StatusEnum::ACTIVE->value)
    //             ->whereHas('agent')
    //             ->whereHas('customer')
    //             ->get();
    //     } catch (Throwable $e) {
    //         Log::error("Error en SalesRepository@getSales: " . $e->getMessage());
    //         throw new Exception("Error al obtener las ventas.");
    //     }
    // }

    // public function saveSale(array $data): Sales
    // {
    //     try {
    //         return Sales::create($data);
    //     } catch (Throwable $e) {
    //         Log::error("Error en SalesRepository@saveSale: " . $e->getMessage());
    //         throw new Exception("Error al guardar la venta.");
    //     }
    // }

    // public function findSaleById(int $saleId): ?Sales
    // {
    //     try {
    //         return Sales::find($saleId);
    //     } catch (Throwable $e) {
    //         Log::error("Error en SalesRepository@findSaleById: " . $e->getMessage());
    //         throw new Exception("Error al buscar la venta.");
    //     }
    // }

    // public function getSalesByAgent(int $agentId, int $pagination): LengthAwarePaginator
    // {
    //     try {
    //         return Sales::with('customer')
    //             ->where('agent_id', $agentId)
    //             ->paginate($pagination, ['*'], 'sales_page'); // 🔹 Eliminamos withQueryString()
    //     } catch (Exception $e) {
    //         Log::error("Error en SalesRepository@getSalesByAgent: " . $e->getMessage());
    //         throw new Exception("Error al obtener ventas por agente.");
    //     }
    // }

    // public function getAmountBySales(int $limit): Collection
    // {
    //     try {
    //         return Sales::selectRaw('SUM(sales.amount) AS monto, agents.name, agents.lastname, areas.name AS area')
    //             ->join('agents', 'sales.agent_id', '=', 'agents.id')
    //             ->join('areas', 'agents.area_id', '=', 'areas.id')
    //             ->groupBy('agents.id', 'areas.name')
    //             ->orderBy('monto', 'desc')
    //             ->take($limit)
    //             ->get();
    //     } catch (Exception $e) {
    //         Log::error("Error en SalesRepository@getAmountBySales: " . $e->getMessage());
    //         throw new Exception("Error al obtener el monto de ventas.");
    //     }
    // }

    // public function updateSale(Sales $sale, array $data): bool
    // {
    //     try {
    //         $sale->fill($data);
    //         return $sale->save();
    //     } catch (Throwable $e) {
    //         Log::error("Error en SalesRepository@updateSale: " . $e->getMessage());
    //         return false;
    //     }
    // }

    // public function searchBonusAgent(string $code, string $name, Area $area, string $dateInit, string $dateEnd): Collection
    // {
    //     try {
    //         return Sales::join('agents as a', 'sales.agent_id', '=', 'a.id')
    //             ->whereIn('sales.action_id', [2, 3])
    //             ->where(function ($query) use ($code, $name) {
    //                 $query->where('a.code', 'LIKE', "%{$code}%")
    //                     ->orWhere(DB::raw("CONCAT(a.name, ' ', a.lastname)"), 'LIKE', "%{$name}%");
    //             })
    //             ->where('a.area_id', $area->id)
    //             ->whereBetween('sales.date_admission', [$dateInit, $dateEnd])
    //             ->get();
    //     } catch (Exception $e) {
    //         Log::error("Error en SalesRepository@searchBonusAgent: " . $e->getMessage());
    //         throw new Exception("Error al buscar bonos.");
    //     }
    // }

    // public function getSalesByActionBetweenDate(int $actionId, string $dateNow, string $monthNow, string $rol, ?Agent $agent = null): Collection
    // {
    //     try {
    //         $query = Sales::join('agents as a', 'sales.agent_id', '=', 'a.id')
    //             ->selectRaw('a.name, a.lastname,
    //                 SUM(CASE WHEN sales.action_id = ? THEN sales.amount ELSE 0 END) AS total_amount_action,
    //                 SUM(CASE WHEN DATE(sales.created_at) = ? THEN sales.amount ELSE 0 END) AS total_amount_day,
    //                 SUM(CASE WHEN DATE_FORMAT(sales.created_at, "%Y-%m") = ? THEN sales.amount ELSE 0 END) AS total_amount_month', 
    //                 [$actionId, $dateNow, $monthNow])
    //             ->addSelect(DB::raw('(SELECT COUNT(*) FROM sales WHERE DATE(sales.created_at) = ? AND sales.agent_id = a.id) AS total_sales_day', [$dateNow]))
    //             ->addSelect(DB::raw('(SELECT COUNT(*) FROM sales WHERE DATE_FORMAT(sales.created_at, "%Y-%m") = ? AND sales.agent_id = a.id) AS total_sales_month', [$monthNow]))
    //             ->groupBy('a.id')
    //             ->orderBy('total_amount_day', 'DESC');
    //         if ($rol !== 'ADMINISTRADOR' && $agent) {
    //             $query->where('sales.agent_id', $agent->id);
    //         }
    //         return $query->get();
    //     } catch (Exception $e) {
    //         Log::error("Error en SalesRepository@getSalesByActionBetweenDate: " . $e->getMessage());
    //         throw new Exception("Error al obtener las ventas por acción entre fechas.");
    //     }
    // }

    // public function getSalesByActionAdmission(int $actionId, string $rol, string $monthNow, string $yearNow, string $previousMonth, string $previousYear, ?Agent $agent = null): Collection
    // {
    //     try {
    //         $query = Sales::where('status', true)
    //             ->where('action_id', $actionId)
    //             ->where(function ($query) use ($monthNow, $yearNow, $previousMonth, $previousYear) {
    //                 $query->whereYear('date_admission', $yearNow)->whereMonth('date_admission', $monthNow)
    //                     ->orWhere(function ($query) use ($previousMonth, $previousYear) {
    //                         $query->whereYear('date_admission', $previousYear)->whereMonth('date_admission', $previousMonth);
    //                     });
    //             })
    //             ->orderBy('date_admission', 'desc');
    //         if ($rol !== 'ADMINISTRADOR' && $agent) {
    //             $query->where('agent_id', $agent->id);
    //         }
    //         return $query->get();
    //     } catch (Exception $e) {
    //         Log::error("Error en SalesRepository@getSalesByActionAdmission: " . $e->getMessage());
    //         throw new Exception("Error al obtener ventas por acción y admisión.");
    //     }
    // }

    // public function filterSalesByDate(string $code, int $areaId, Carbon $dateInit, Carbon $dateEnd): Collection
    // {
    //     try {
    //         return Sales::whereHas('agent', function ($query) use ($code, $areaId) {
    //                 if (!empty($areaId)) {
    //                     $query->where('area_id', $areaId);
    //                 }
    //                 if (!empty($code)) {
    //                     $query->where(function ($q) use ($code) {
    //                         $q->where('code_voiso', $code)
    //                             ->orWhere('name', 'LIKE', "%$code%")
    //                             ->orWhere('lastname', 'LIKE', "%$code%");
    //                     });
    //                 }
    //             })
    //             ->whereDate('date_admission', '>=', $dateInit)
    //             ->whereDate('date_admission', '<=', $dateEnd)
    //             ->with(['agent', 'customer'])
    //             ->get();
    //     } catch (Exception $e) {
    //         Log::error("Error en SalesRepository@filterSalesByDate: " . $e->getMessage());
    //         throw new Exception("Error al filtrar ventas por fecha.");
    //     }
    // }

    // public function getBonusAction(array $actions): Collection
    // {
    //     try {
    //         return Sales::where('status', StatusEnum::ACTIVE->value)
    //             ->whereIn('action_id', $actions)
    //             ->orderBy('created_at', 'desc')
    //             ->get();
    //     } catch (Exception $e) {
    //         Log::error("Error en SalesRepository@getBonusAction: " . $e->getMessage());
    //         throw new Exception("Error al obtener bonos por acción.");
    //     }
    // }

    

    // public function getAmountDateByAgent(Agent $agent, MovementType $movementType): float
    // {
    //     try {
    //         return (float)Sales::join('actions', 'sales.action_id', '=', 'actions.id')
    //             ->where('actions.movement_type_id', $movementType->value)
    //             ->where('actions.status', StatusEnum::ACTIVE->value)
    //             ->where('sales.status', StatusEnum::ACTIVE->value)
    //             ->where('sales.agent_id', $agent->id)
    //             ->whereMonth('sales.created_at', date("m"))
    //             ->sum('sales.amount');
    //     } catch (Exception $e) {
    //         Log::error("Error en SalesRepository@getAmountDateByAgent: " . $e->getMessage());
    //         throw new Exception("Error al obtener monto por agente.");
    //     }
    // }

    // public function getAmountByArea(int $areaId): float
    // {
    //     try {
    //         return (float)Sales::join('agents', 'sales.agent_id', '=', 'agents.id')
    //             ->where('agents.area_id', $areaId)
    //             ->sum('sales.amount');
    //     } catch (Exception $e) {
    //         Log::error("Error en SalesRepository@getAmountByArea: " . $e->getMessage());
    //         throw new Exception("Error al obtener el monto por área.");
    //     }
    // }
    
}
