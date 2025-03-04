<?php
namespace App\Repositories;

use App\Enums\AssistanceType;
use App\Interfaces\AssistanceRepositoryInterface;
use App\Models\Assistance;
use Exception;
use Illuminate\Database\QueryException;
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
}
