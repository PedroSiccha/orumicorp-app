<?php
namespace App\Repositories;

use App\Enums\AssistanceType;
use App\Http\Requests\StoreAssistanceRequest;
use App\Interfaces\AssistanceRepositoryInterface;
use App\Models\Agent;
use App\Models\Assistance;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssistanceRepository implements AssistanceRepositoryInterface
{
    public function findAssistanceDateByTypeAgent(string $date, AssistanceType $typeAssistance, int $agentId): Assistance
    {
        try {
            return Assistance::where('date', $date)->where('type', $typeAssistance->value)->where('agent_id', $agentId)->first();
        } catch (QueryException $e) {
            Log::error("Error AssistanceRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AssistanceRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getReportAssistanceByAgent(Agent $agent): ?Agent
    {
        try {
            return Assistance::select(
                                'agents.name',
                                'agents.lastname',
                                'assistance.date',
                                DB::raw("MAX(CASE WHEN assistance.type = 'IN' THEN assistance.hour END) AS 'IN'"),
                                DB::raw("MAX(CASE WHEN assistance.type = 'IN-BREAK' THEN assistance.hour END) AS 'INBREAK'"),
                                DB::raw("MAX(CASE WHEN assistance.type = 'OUT-BREAK' THEN assistance.hour END) AS 'OUTBREAK'"),
                                DB::raw("MAX(CASE WHEN assistance.type = 'OUT' THEN assistance.hour END) AS 'OUT'")
                            )
                            ->join('agents', 'assistance.agent_id', '=', 'agents.id')
                            ->where('agents.id', $agent->id)
                            ->groupBy('agents.name', 'agents.lastname', 'assistance.date')
                            ->get();
        } catch (QueryException $e) {
            Log::error("Error AssistanceRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AssistanceRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getReportAssistanceNow(string $currentDate) 
    {
        try {
            return DB::table('assistance as a')
                        ->join('agents as ag', 'a.agent_id', '=', 'ag.id')
                        ->join('areas as ar', 'ag.area_id', '=', 'ar.id')
                        ->select(
                            'a.date',
                            'a.agent_id',
                            'ag.name as agent_name',
                            'ag.lastname as last_name',
                            'ar.name as area_name',
                            'a.hour',
                            'a.type',
                            'a.observation'
                        )
                        ->where('a.date', $currentDate) 
                        ->orderBy('a.date', 'DESC')
                        ->orderBy('a.hour', 'ASC')
                        ->get();
        } catch (QueryException $e) {
            Log::error("Error AssistanceRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AssistanceRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveAssistance(StoreAssistanceRequest $dataAssistance): ?Assistance
    {
        try {
            return Assistance::create($dataAssistance);
        } catch (QueryException $e) {
            Log::error("Error AssistanceRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AssistanceRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function searchAssistance(string $startDate, string $endDate, string $nombre, string $area): Collection
    {
        try {
            $query = DB::table('assistance as a')
                        ->join('agents as ag', 'a.agent_id', '=', 'ag.id')
                        ->join('areas as ar', 'ag.area_id', '=', 'ar.id')
                        ->select(
                            'a.date',
                            'a.agent_id',
                            'ag.name as agent_name',
                            'ag.lastname as last_name',
                            'ar.name as area_name',
                            'a.hour',
                            'a.type',
                            'a.observation'
                        )
                        ->whereBetween('a.date', [$startDate, $endDate]) 
                        ->orderBy('a.date', 'DESC')
                        ->orderBy('a.hour', 'ASC');

            if (!empty($nombre)) {
                $query->where(DB::raw("CONCAT(ag.name, ' ', ag.lastname)"), 'LIKE', "%{$nombre}%");
            }

            if (!empty($area)) {
                $query->where('ag.area_id', $area);
            }

            return $query->get();
        } catch (QueryException $e) {
            Log::error("Error AssistanceRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AssistanceRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }
}
