<?php
namespace App\Interfaces;

use App\Enums\AssistanceType;
use App\Http\Requests\StoreAssistanceRequest;
use App\Models\Agent;
use App\Models\Assistance;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

interface AssistanceRepositoryInterface
{
    public function findAssistanceDateByTypeAgent(string $date, AssistanceType $typeAssistance, int $agentId): Assistance;
    public function getReportAssistanceByAgent(Agent $agent): ?Agent;
    public function getReportAssistanceNow(string $currentDate);
    public function saveAssistance(StoreAssistanceRequest $dataAssistance): ?Assistance;
    public function searchAssistance(string $startDate, string $endDate, string $nombre, string $area): Collection;
}
