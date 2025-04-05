<?php
namespace App\DTOs\Agent;

use Illuminate\Pagination\LengthAwarePaginator;

class AgentIndexDTO
{
    public LengthAwarePaginator $agents;
    public $rouletteSpin;
    public $dataUser;
    public $areas;
    public $roles;

    public function __construct(array $data)
    {
        $data = array_merge([
            'roles' => [],
            'dataUser' => null,
            'rouletteSpin' => null,
            'agents' => [],
            'areas' => []
        ], $data);

        $this->roles = $data['roles'];
        $this->dataUser = $data['dataUser'];
        $this->rouletteSpin = $data['rouletteSpin'];
        $this->agents = $data['agents'];
        $this->areas = $data['areas'];
    }
}
