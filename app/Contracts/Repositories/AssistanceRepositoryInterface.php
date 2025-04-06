<?php
namespace App\Contracts\Repositories;

interface AssistanceRepositoryInterface
{
    public function create(array $data);
    public function getTodayByAgent($agentId);
    public function getTodayGrouped();
}
