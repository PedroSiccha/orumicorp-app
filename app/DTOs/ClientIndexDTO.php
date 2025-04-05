<?php
namespace App\DTOs;

use Illuminate\Pagination\LengthAwarePaginator;

class ClientIndexDTO
{
    public LengthAwarePaginator $customers;
    public $premios1;
    public $premios2;
    public $roles;
    public $dataUser;
    public $rouletteSpin;
    public $asignCustomers;
    public $myRolesId;
    public $providers;
    public $platforms;
    public $traidings;
    public $statusCustomers;
    public $folders;
    public $agents;
    public $campaigns;

    public function __construct(array $data)
    {
        $data = array_merge([
            'premios1' => null,
            'premios2' => null,
            'roles' => null,
            'dataUser' => null,
            'rouletteSpin' => null,
            'asignCustomers' => null,
            'myRolesId' => null,
            'providers' => [],
            'platforms' => [],
            'traidings' => [],
            'statusCustomers' => [],
            'folders' => [],
            'agents' => [],
            'campaigns' => []
        ], $data);

        $this->customers = $data['customers'];
        $this->premios1 = $data['premios1'];
        $this->premios2 = $data['premios2'];
        $this->roles = $data['roles'];
        $this->dataUser = $data['dataUser'];
        $this->rouletteSpin = $data['rouletteSpin'];
        $this->asignCustomers = $data['asignCustomers'];
        $this->myRolesId = $data['myRolesId'];
        $this->providers = $data['providers'];
        $this->platforms = $data['platforms'];
        $this->traidings = $data['traidings'];
        $this->statusCustomers = $data['statusCustomers'];
        $this->folders = $data['folders'];
        $this->agents = $data['agents'];
        $this->campaigns = $data['campaigns'];
    }
}
