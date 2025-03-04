<?php
namespace App\Interfaces;

use App\Enums\AssistanceType;
use App\Models\Assistance;

interface AssistanceRepositoryInterface
{
    public function findAssistanceDateByTypeAgent(string $date, AssistanceType $typeAssistance, int $agentId): Assistance;
}
