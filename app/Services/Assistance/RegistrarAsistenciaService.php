<?php
namespace App\Services\Assistance;

use App\Contracts\Repositories\AssistanceRepositoryInterface;
use App\Models\Agent;
use Illuminate\Support\Facades\Auth;
use Exception;

class RegistrarAsistenciaService
{
    protected $repo;

    public function __construct(AssistanceRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function ejecutar(array $data): void
    {
        $user = Auth::user();
        if (!$user) {
            throw new Exception("Usuario no autenticado.");
        }

        $agent = Agent::where('user_id', $user->id)->first();
        if (!$agent) {
            throw new Exception("No se encontró un agente vinculado al usuario.");
        }

        $data['agent_id'] = $agent->id;

        $this->repo->create($data);
    }
}
