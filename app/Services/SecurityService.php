<?php
namespace App\Services;

use Illuminate\Http\Request;

class SecurityService
{

    protected $securityRepository;

    public function __construct(
        SecurityRepositoryInterface $securityRepository
    ) {
      $this->securityRepository = $securityRepository;  
    }

    public function getSecurityData()
    {
        // $user_id = Auth::user()->id;

        // $agent = Agent::where('user_id', $user_id)->first();
        // $client = Customers::where('user_id', $user_id)->first();
        // $rouletteSpin = $agent->number_turns ?: 0;

        // $dataUser = null;

        // if ($agent) {
        //     $dataUser = $agent;
        // }

        // if ($client) {
        //     $dataUser = $client;
        // }

        // $roles = Role::paginate(10)->withQueryString();
        // $permisos = Permission::get();
        // $premios1 = Premio::where('status', true)->where('type', 1)->get();
        // $premios2 = Premio::where('status', true)->where('type', 2)->get();
        // return view('security.index', compact('premios1', 'premios2', 'roles', 'permisos', 'dataUser', 'rouletteSpin'));
    }

    public function saveRol(Request $request)
    {
        // $resp = 0;

        // $role = Role::create(['name' => $request->name]);
        // if ($role) {
        //     $resp = 1;
        // }

        // $roles = Role::get();

        // return response()->json(["view"=>view('security.components.tabRoles', compact('roles'))->render(), "resp"=>$resp]);
    }

    public function getPermisos(Request $request)
    {
        // $rol = Role::where('id', $request->id)->first();

        // if ($rol) {
        //     $permisos = $rol->permissions;
        // }

        // return response()->json(["view"=>view('security.components.tabPermisos', compact('permisos'))->render()]);
    }

    public function asignarPermisoRol(Request $request)
    {
        // $resp = 0;

        // $rol_id = $request->rol_id;
        // $permiso_id = $request->idPermiso;

        // $rol = Role::findById($rol_id);

        // for ($i=0; $i < count($permiso_id) ; $i++) {

        //     $permiso = Permission::find($permiso_id);

        //     $rol->givePermissionTo($permiso);

        //     if ($rol) {
        //         $resp = 1;
        //     }

        // }

        // if ($rol) {
        //     $permisos = $rol->permissions;
        // }

        // return response()->json(["view"=>view('security.components.tabPermisos', compact('permisos'))->render(), "resp"=>$resp]);
    }

    public function deletePermiso(Request $request)
    {
        // $rol = Role::findById($request->idRol);
        // $permiso = Permission::find($request->idPermiso);
        // $rol->revokePermissionTo($permiso);

        // $rol = Role::where('id', $request->idRol)->first();

        // if ($rol) {
        //     $permisos = $rol->permissions;
        // }

        // return response()->json(["view"=>view('security.components.tabPermisos', compact('permisos'))->render()]);
    }
}