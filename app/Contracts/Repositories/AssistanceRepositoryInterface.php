<?php
namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface AssistanceRepositoryInterface
{
    public function create(array $data);

    public function getTodayByAgent(int $agentId);

    public function getTodayGrouped(): Collection;
}
 