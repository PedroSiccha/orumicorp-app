<?php
namespace App\Services\Assistance;

use App\Contracts\Repositories\AssistanceRepositoryInterface;
use App\Models\Agent;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;

class RegistrarAsistenciaService
{
    protected AssistanceRepositoryInterface $repository;

    public function __construct(AssistanceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function ejecutar(array $data): void
    {
        $agent = Agent::where('user_id', Auth::user()->id)->first();
        if (!$agent) {
            throw new Exception('El usuario actual no tiene un agente asignado.');
        }

        $data['agent_id'] = $agent->id;

        try {
            $this->repository->create($data);
        } catch (Exception $e) {
            Log::error('Error al registrar asistencia: ' . $e->getMessage());
            throw new Exception('No se pudo registrar la asistencia. Intente más tarde.');
        }
    }
}