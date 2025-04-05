<?php
namespace App\Interfaces;

use App\Enums\AssistanceType;
use App\Models\Agent;
use App\Models\Assistance;
use Illuminate\Database\Eloquent\Collection;

interface AssistanceRepositoryInterface
{
    public function findAssistanceDateByTypeAgent(string $date, AssistanceType $typeAssistance, int $agentId): ?Assistance;
    public function getReportAssistanceByAgent(Agent $agent): Collection;
    public function getReportAssistanceNow(string $currentDate): Collection;
    public function saveAssistance(array $dataAssistance): ?Assistance;
    public function searchAssistance(string $startDate, string $endDate, string $nombre, string $area): Collection;
}
