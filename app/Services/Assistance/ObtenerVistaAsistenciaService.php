<?php
namespace App\Services\Assistance;

use App\Contracts\Repositories\AssistanceRepositoryInterface;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Carbon;

class ObtenerVistaAsistenciaService
{
    protected AssistanceRepositoryInterface $repository;

    public function __construct(AssistanceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function ejecutar(int $agentId): array
    {
        $date = Carbon::now()->toDateString();

        return [
            'dateIn'       => $this->repository->getTodayByAgent($agentId, $date, 'IN'),
            'dateBreakIn'  => $this->repository->getTodayByAgent($agentId, $date, 'IN-BREAK'),
            'dateBreakOut' => $this->repository->getTodayByAgent($agentId, $date, 'OUT-BREAK'),
            'dateOut'      => $this->repository->getTodayByAgent($agentId, $date, 'OUT'),
            'assistances'  => $this->repository->getTodayGrouped(),
        ];
    }
}
