<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Customers;
use App\Models\Premio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SecurityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

/*
        $permission = Permission::create(['name' => 'Perfil - Ver Target Mensual']);
        $permission = Permission::create(['name' => 'Perfil - Ver Ingresos Actuales']);
        $permission = Permission::create(['name' => 'Perfil - Ver Retiros Actuales']);
        $permission = Permission::create(['name' => 'Perfil - Ver Cuota Pendiente']);
        $permission = Permission::create(['name' => 'Perfil - Ver Pago en Efectivo']);
        $permission = Permission::create(['name' => 'Perfil - Ver Descuentos']);

        $permission = Permission::create(['name' => 'Tabla Today Statistics - Ver Total Calls']);
        $permission = Permission::create(['name' => 'Tabla Today Statistics - Ver Retiros']);
        $permission = Permission::create(['name' => 'Tabla Today Statistics - Ver Chargeback']);

        $permission = Permission::create(['name' => 'Asignar Cliente Masivo']);
        $permission = Permission::create(['name' => 'Carga Masiva de Cliente']);
        $permission = Permission::create(['name' => 'Asignar Agente']);
        $permission = Permission::create(['name' => 'Descargar Part Time Excel']);
        $permission = Permission::create(['name' => 'Descargar Part Time PDF']);
        $permission = Permission::create(['name' => 'Quitar Permiso']);
        $permission = Permission::create(['name' => 'Ver Ventas Tablero']);
        $permission = Permission::create(['name' => 'Ver Cantidad Agentes Tablero']);
        $permission = Permission::create(['name' => 'Ver Cantidad Clientes Tablero']);
        $permission = Permission::create(['name' => 'Estadistica de Ventas']);
        $permission = Permission::create(['name' => 'Rankig de Ventas Tablero']);
        $permission = Permission::create(['name' => 'Agregar Evento']);
        $permission = Permission::create(['name' => 'Editar Venta']);
        $permission = Permission::create(['name' => 'Ver Task']);
        $permission = Permission::create(['name' => 'Ver Auditoria']);

        $permission = Permission::create(['name' => 'Ver Permisos de Roles']);
        $permission = Permission::create(['name' => 'Asignar Permisos']);
        $permission = Permission::create(['name' => 'Estado Cliente']);
        $permission = Permission::create(['name' => 'Ver Agentes']);
        $permission = Permission::create(['name' => 'Registrar Roles']);
        $permission = Permission::create(['name' => 'Ver Permisos de Roles']);
        $permission = Permission::create(['name' => 'Asignar Permisos']);
        $permission = Permission::create(['name' => 'Estado Cliente']);
        $permission = Permission::create(['name' => 'Ver Agentes']);
        $permission = Permission::create(['name' => 'Registrar Roles']);
        $permission = Permission::create(['name' => 'Ver Permisos de Roles']);
        $permission = Permission::create(['name' => 'Asignar Permisos']);
        $permission = Permission::create(['name' => 'Estado Cliente']);
        $permission = Permission::create(['name' => 'Ver Agentes']);
        $permission = Permission::create(['name' => 'Registrar Roles']);
        $permission = Permission::create(['name' => 'Ver Permisos de Roles']);
        $permission = Permission::create(['name' => 'Asignar Permisos']);
        $permission = Permission::create(['name' => 'Estado Cliente']);
        $permission = Permission::create(['name' => 'Ver Agentes']);
        $permission = Permission::create(['name' => 'Registrar Roles']);
        $permission = Permission::create(['name' => 'Ver Permisos de Roles']);
        $permission = Permission::create(['name' => 'Asignar Permisos']);
        $permission = Permission::create(['name' => 'Estado Cliente']);
        */
        //Nuevo Permisos
        // $permission = Permission::create(['name' => 'Editar Campania']);
        // $permission = Permission::create(['name' => 'Crear Campania']);
        // $permission = Permission::create(['name' => 'Eliminar Campania']);
        // $permission = Permission::create(['name' => 'Asignar Folder']);
        // $permission = Permission::create(['name' => 'Liberar Cliente']);
        // $permission = Permission::create(['name' => 'Cambiar Estado Cliente']);
        // $permission = Permission::create(['name' => 'Llamadas VOISO']);
        // $permission = Permission::create(['name' => 'Editar Estados de Cliente']);
        // $permission = Permission::create(['name' => 'Crear Estado Cliente']);
        // $permission = Permission::create(['name' => 'Eliminar Estados de Cliente']);
        // $permission = Permission::create(['name' => 'Nuevo Deposito']);
        // $permission = Permission::create(['name' => 'Ver Whatsapp']);
        // $permission = Permission::create(['name' => 'Ver Mail']);
        // $permission = Permission::create(['name' => 'Ver Shooter']);
        // $permission = Permission::create(['name' => 'Ver Deposit']);
        // $permission = Permission::create(['name' => 'Ver Mantenimiento']);
        // $permission = Permission::create(['name' => 'Editar Proveedor']);
        // $permission = Permission::create(['name' => 'Eliminar Proveedor']);
        // $permission = Permission::create(['name' => 'Crear Proveedores']);
        // $permission = Permission::create(['name' => 'Eliminar Plataforma']);
        // $permission = Permission::create(['name' => 'Editar Plataforma']);
        // $permission = Permission::create(['name' => 'Crear Plataforma']);
        // $permission = Permission::create(['name' => 'Editar Traiding']);
        // $permission = Permission::create(['name' => 'Eliminar Traiding']);
        // $permission = Permission::create(['name' => 'Crear Traiding']);
        // $permission = Permission::create(['name' => 'Editar Tipo Transaccion']);
        // $permission = Permission::create(['name' => 'Eliminar Tipo Transaccion']);
        // $permission = Permission::create(['name' => 'Crear Tipo Transanccion']);
        // $permission = Permission::create(['name' => 'Activar Shooter']);
        // $permission = Permission::create(['name' => 'Administrar Shooter']);
        // $permission = Permission::create(['name' => 'Lista Shooter']);
        // $permission = Permission::create(['name' => 'Crear Carpeta']);
        // $permission = Permission::create(['name' => 'Renombrar Carpeta']);
        // $permission = Permission::create(['name' => 'Eliminar Carpeta']);
        // $permission = Permission::create(['name' => 'Agregar Cliente a Carpeta']);
        // $permission = Permission::create(['name' => 'Carga Masiva a Carpetas']);
        // $permission = Permission::create(['name' => 'Editar Campania']);
        // $permission = Permission::create(['name' => 'Crear Campania']);
        // $permission = Permission::create(['name' => 'Eliminar Campania']);
        // $permission = Permission::create(['name' => 'Asignar Folder']);
        // $permission = Permission::create(['name' => 'Liberar Cliente']);
        // $permission = Permission::create(['name' => 'Cambiar Estado Cliente']);
        // $permission = Permission::create(['name' => 'Llamadas VOISO']);
        // $permission = Permission::create(['name' => 'Editar Estados de Cliente']);
        // $permission = Permission::create(['name' => 'Crear Estado Cliente']);
        // $permission = Permission::create(['name' => 'Eliminar Estados de Cliente']);
        // $permission = Permission::create(['name' => 'Nuevo Deposito']);
        // $permission = Permission::create(['name' => 'Ver Whatsapp']);
        // $permission = Permission::create(['name' => 'Ver Mail']);
        // $permission = Permission::create(['name' => 'Ver Shooter']);
        // $permission = Permission::create(['name' => 'Ver Deposit']);
        // $permission = Permission::create(['name' => 'Ver Mantenimiento']);
        // $permission = Permission::create(['name' => 'Editar Proveedor']);
        // $permission = Permission::create(['name' => 'Eliminar Proveedor']);
        // $permission = Permission::create(['name' => 'Crear Proveedores']);
        // $permission = Permission::create(['name' => 'Eliminar Plataforma']);
        // $permission = Permission::create(['name' => 'Editar Plataforma']);
        // $permission = Permission::create(['name' => 'Crear Plataforma']);
        // $permission = Permission::create(['name' => 'Editar Traiding']);
        // $permission = Permission::create(['name' => 'Eliminar Traiding']);
        // $permission = Permission::create(['name' => 'Crear Traiding']);
        // $permission = Permission::create(['name' => 'Editar Tipo Transaccion']);
        // $permission = Permission::create(['name' => 'Eliminar Tipo Transaccion']);
        // $permission = Permission::create(['name' => 'Crear Tipo Transanccion']);
        // $permission = Permission::create(['name' => 'Activar Shooter']);
        // $permission = Permission::create(['name' => 'Administrar Shooter']);
        // $permission = Permission::create(['name' => 'Lista Shooter']);
        // $permission = Permission::create(['name' => 'Crear Carpeta']);
        // $permission = Permission::create(['name' => 'Renombrar Carpeta']);
        // $permission = Permission::create(['name' => 'Eliminar Carpeta']);
        // $permission = Permission::create(['name' => 'Agregar Cliente a Carpeta']);
        // $permission = Permission::create(['name' => 'Carga Masiva a Carpetas']);

        $user_id = Auth::user()->id;

        $agent = Agent::where('user_id', $user_id)->first();
        $client = Customers::where('user_id', $user_id)->first();
        $rouletteSpin = $agent->number_turns ?: 0;

        $dataUser = null;

        if ($agent) {
            $dataUser = $agent;
        }

        if ($client) {
            $dataUser = $client;
        }

        $roles = Role::paginate(10)->withQueryString();
        $permisos = Permission::get();
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        return view('security.index', compact('premios1', 'premios2', 'roles', 'permisos', 'dataUser', 'rouletteSpin'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveRol(Request $request)
    {
        $resp = 0;

        $role = Role::create(['name' => $request->name]);
        if ($role) {
            $resp = 1;
        }

        $roles = Role::get();

        return response()->json(["view"=>view('security.components.tabRoles', compact('roles'))->render(), "resp"=>$resp]);
    }

    public function verPermisos(Request $request)
    {
        $rol = Role::where('id', $request->id)->first();

        if ($rol) {
            $permisos = $rol->permissions;
        }

        return response()->json(["view"=>view('security.components.tabPermisos', compact('permisos'))->render()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function asignarPermisoRol(Request $request)
    {
        $resp = 0;

        $rol_id = $request->rol_id;
        $permiso_id = $request->idPermiso;

        $rol = Role::findById($rol_id);

        for ($i=0; $i < count($permiso_id) ; $i++) {

            $permiso = Permission::find($permiso_id);

            $rol->givePermissionTo($permiso);

            if ($rol) {
                $resp = 1;
            }

        }

        if ($rol) {
            $permisos = $rol->permissions;
        }

        return response()->json(["view"=>view('security.components.tabPermisos', compact('permisos'))->render(), "resp"=>$resp]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletePermiso(Request $request)
    {
        $rol = Role::findById($request->idRol);
        $permiso = Permission::find($request->idPermiso);
        $rol->revokePermissionTo($permiso);

        $rol = Role::where('id', $request->idRol)->first();

        if ($rol) {
            $permisos = $rol->permissions;
        }

        return response()->json(["view"=>view('security.components.tabPermisos', compact('permisos'))->render()]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
