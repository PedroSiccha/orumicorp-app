<?php
namespace App\Repositories;

use App\Http\Requests\StoreBonusAgentRequest;
use App\Interfaces\AgentBonusRepositoryInterface;
use App\Models\BonusAgent;
use App\Models\Sales;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class AgentBonusRepository implements AgentBonusRepositoryInterface
{

    public function getBonusAgent(array $actions, bool $status, string $order): Collection
    {
        try {
            return Sales::whereIn('action_id', $actions)
                                    ->where('status', $status)
                                    ->orderBy('date_admission', $order)
                                    ->with('action')
                                    ->get();
        } catch (QueryException $e) {
            Log::error("Error AgentBonusRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AgentBonusRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveBonus(StoreBonusAgentRequest $data): BonusAgent
    {
        try {
            return BonusAgent::create($data);
        } catch (QueryException $e) {
            Log::error("Error AgentBonusRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AgentBonusRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }
}
