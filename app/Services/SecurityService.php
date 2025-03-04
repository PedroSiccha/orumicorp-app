<?php
namespace App\Services;

use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\SecurityRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class SecurityService
{

    protected $securityRepository, $userRepository, $clientRepository, $agentRepository;

    public function __construct(
        SecurityRepositoryInterface $securityRepository,
        UserRepositoryInterface $userRepository,
        ClientRepositoryInterface $clientRepository,
        AgentRepositoryInterface $agentRepository
    ) {
      $this->securityRepository = $securityRepository;  
      $this->userRepository = $userRepository;  
      $this->clientRepository = $clientRepository;  
      $this->agentRepository = $agentRepository;  
    }

    public function getSecurityData()
    {
        $user = $this->userRepository->getUser();

        $agent = $this->agentRepository->getAgentByUserId($user->id); // Agent::where('user_id', $user_id)->first();
        $client = $this->clientRepository->getClientByUserId($user->id); // Customers::where('user_id', $user_id)->first();
        $rouletteSpin = $agent->number_turns ?: 0;

        // $dataUser = null;

        // if ($agent) {
        //     $dataUser = $agent;
        // }

        // if ($client) {
        //     $dataUser = $client;
        // }

        $roles = $this->securityRepository->getRoles(10);
        $permisos = $this->securityRepository->getPermission(10);
        // $premios1 = Premio::where('status', true)->where('type', 1)->get();
        // $premios2 = Premio::where('status', true)->where('type', 2)->get();
        // return view('security.index', compact('premios1', 'premios2', 'roles', 'permisos', 'dataUser', 'rouletteSpin'));
    }

    public function saveRol(Request $request)
    {
        // $resp = 0;

        $role = $this->securityRepository->saveRol($request);
        // if ($role) {
        //     $resp = 1;
        // }

        $roles = $this->securityRepository->getRoles(10);

        // return response()->json(["view"=>view('security.components.tabRoles', compact('roles'))->render(), "resp"=>$resp]);
    }

    public function getPermisos(Request $request)
    {
        $rol = $this->securityRepository->getRolesById($request->id);

        if ($rol) {
            $permisos = $rol->permissions;
        }

        // return response()->json(["view"=>view('security.components.tabPermisos', compact('permisos'))->render()]);
    }

    public function asignarPermisoRol(Request $request)
    {
        // $resp = 0;

        // $rol_id = $request->rol_id;
        // $permiso_id = $request->idPermiso;

        $rol = $this->securityRepository->getRolesById($request->rol_id);

        for ($i=0; $i < count($request->idPermiso) ; $i++) {

            $permiso = $this->securityRepository->getPermiPermissionById($request->idPermiso);

            $rol->givePermissionTo($permiso);

            if ($rol) {
                $resp = 1;
            }

        }

        if ($rol) {
            $permisos = $rol->permissions;
        }

        // return response()->json(["view"=>view('security.components.tabPermisos', compact('permisos'))->render(), "resp"=>$resp]);
    }

    public function deletePermiso(Request $request)
    {
        $rol = $this->securityRepository->getRolesById($request->idRol);
        $permiso = $this->securityRepository->getPermiPermissionById($request->idPermiso);
        $rol->revokePermissionTo($permiso);

        // $rol = Role::where('id', $request->idRol)->first();

        if ($rol) {
            $permisos = $rol->permissions;
        }

        // return response()->json(["view"=>view('security.components.tabPermisos', compact('permisos'))->render()]);
    }
}