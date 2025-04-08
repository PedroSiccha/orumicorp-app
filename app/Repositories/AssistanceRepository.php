<?php
namespace App\Repositories;

use App\Contracts\Repositories\AssistanceRepositoryInterface;
use App\Enums\AssistanceType;
use App\Models\Agent;
use App\Models\Assistance;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class AssistanceRepository implements AssistanceRepositoryInterface
{

    public function create(array $data)
    {
        return Assistance::create($data);
    }

    public function getTodayByAgent($agentId)
    {
        return Assistance::where('date', today())
                         ->where('agent_id', $agentId)
                         ->get();
    }

    public function getTodayGrouped(): Collection
    {
        $currentDate = Carbon::now()->toDateString();

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
    }

    // public function findAssistanceDateByTypeAgent(string $date, AssistanceType $typeAssistance, int $agentId): ?Assistance
    // {
    //     try {
    //         return Assistance::where('date', $date)
    //             ->where('type', $typeAssistance->value)
    //             ->where('agent_id', $agentId)
    //             ->first();
    //     } catch (Throwable $e) {
    //         Log::error("Error en findAssistanceDateByTypeAgent: " . $e->getMessage());
    //         return null;
    //     }
    // }

    // public function getReportAssistanceByAgent(Agent $agent): Collection
    // {
    //     try {
    //         return Assistance::select(
    //             'agents.name',
    //             'agents.lastname',
    //             'assistance.date',
    //             DB::raw("MAX(CASE WHEN assistance.type = 'IN' THEN assistance.hour END) AS 'IN'"),
    //             DB::raw("MAX(CASE WHEN assistance.type = 'IN-BREAK' THEN assistance.hour END) AS 'INBREAK'"),
    //             DB::raw("MAX(CASE WHEN assistance.type = 'OUT-BREAK' THEN assistance.hour END) AS 'OUTBREAK'"),
    //             DB::raw("MAX(CASE WHEN assistance.type = 'OUT' THEN assistance.hour END) AS 'OUT'")
    //         )
    //         ->join('agents', 'assistance.agent_id', '=', 'agents.id')
    //         ->where('agents.id', $agent->id)
    //         ->groupBy('agents.name', 'agents.lastname', 'assistance.date')
    //         ->get();
    //     } catch (Throwable $e) {
    //         Log::error("Error en getReportAssistanceByAgent: " . $e->getMessage());
    //         return collect();
    //     }
    // }

    // public function getReportAssistanceNow(string $currentDate): Collection
    // {
    //     try {
    //         return DB::table('assistance as a')
    //             ->join('agents as ag', 'a.agent_id', '=', 'ag.id')
    //             ->join('areas as ar', 'ag.area_id', '=', 'ar.id')
    //             ->select(
    //                 'a.date',
    //                 'a.agent_id',
    //                 'ag.name as agent_name',
    //                 'ag.lastname as last_name',
    //                 'ar.name as area_name',
    //                 'a.hour',
    //                 'a.type',
    //                 'a.observation'
    //             )
    //             ->where('a.date', $currentDate)
    //             ->orderBy('a.date', 'DESC')
    //             ->orderBy('a.hour', 'ASC')
    //             ->get();
    //     } catch (Throwable $e) {
    //         Log::error("Error en getReportAssistanceNow: " . $e->getMessage());
    //         return collect();
    //     }
    // }

    // public function saveAssistance(array $dataAssistance): ?Assistance
    // {
    //     try {
    //         return Assistance::create($dataAssistance);
    //     } catch (Throwable $e) {
    //         Log::error("Error en saveAssistance: " . $e->getMessage());
    //         return null;
    //     }
    // }

    // public function searchAssistance(string $startDate, string $endDate, ?string $nombre = null, ?string $area = null): Collection
    // {
    //     try {
    //         $query = DB::table('assistance as a')
    //             ->join('agents as ag', 'a.agent_id', '=', 'ag.id')
    //             ->join('areas as ar', 'ag.area_id', '=', 'ar.id')
    //             ->select(
    //                 'a.date',
    //                 'a.agent_id',
    //                 'ag.name as agent_name',
    //                 'ag.lastname as last_name',
    //                 'ar.name as area_name',
    //                 'a.hour',
    //                 'a.type',
    //                 'a.observation'
    //             )
    //             ->whereBetween('a.date', [$startDate, $endDate])
    //             ->orderBy('a.date', 'DESC')
    //             ->orderBy('a.hour', 'ASC');

    //         if (!empty($nombre)) {
    //             $query->where(DB::raw("CONCAT(ag.name, ' ', ag.lastname)"), 'LIKE', "%{$nombre}%");
    //         }

    //         if (!empty($area)) {
    //             $query->where('ag.area_id', $area);
    //         }

    //         return $query->get();
    //     } catch (Throwable $e) {
    //         Log::error("Error en searchAssistance: " . $e->getMessage());
    //         return collect();
    //     }
    // }

    // // Aqui vamos a probar lo nuevo con CHATGPT
    // public function create(array $data)
    // {
    //     return Assistance::create($data);
    // }

    // public function getTodayByAgent($agentId)
    // {
    //     return Assistance::where('date', today())
    //                      ->where('agent_id', $agentId)
    //                      ->get();
    // }

    // public function getTodayGrouped()
    // {
    //     $currentDate = Carbon::now()->toDateString();

    //     return DB::table('assistance as a')
    //                 ->join('agents as ag', 'a.agent_id', '=', 'ag.id')
    //                 ->join('areas as ar', 'ag.area_id', '=', 'ar.id')
    //                 ->select(
    //                     'a.date',
    //                     'a.agent_id',
    //                     'ag.name as agent_name',
    //                     'ag.lastname as last_name',
    //                     'ar.name as area_name',
    //                     'a.hour',
    //                     'a.type',
    //                     'a.observation'
    //                 )
    //                 ->where('a.date', $currentDate)
    //                 ->orderBy('a.date', 'DESC')
    //                 ->orderBy('a.hour', 'ASC')
    //                 ->get();
    // }

}
