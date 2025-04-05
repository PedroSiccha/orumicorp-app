<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Customers;
use App\Models\Premio;
use App\Services\SecurityService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SecurityController extends Controller
{
    protected $securityService;

    public function __construct(SecurityService $securityService) {
        $this->securityService = $securityService;
    }

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

        //Agregar Actualizacion Noviembre

        // $permission = Permission::create(['name' => 'Ver Perfil Cliente']);
        // $permission = Permission::create(['name' => 'Perfil Cliente - Ver Codigo']);
        // $permission = Permission::create(['name' => 'Perfil Cliente - Ver Nombre']);
        // $permission = Permission::create(['name' => 'Perfil Cliente - Ver Apellido']);
        // $permission = Permission::create(['name' => 'Perfil Cliente - Ver Correo']);
        // $permission = Permission::create(['name' => 'Perfil Cliente - Ver Telefono']);
        // $permission = Permission::create(['name' => 'Perfil Cliente - Ver Telefono Opcional']);
        // $permission = Permission::create(['name' => 'Perfil Cliente - Ver Ciudad']);
        // $permission = Permission::create(['name' => 'Perfil Cliente - Ver Pais']);

        try {
            $data = $this->securityService->getSecurityData();
            $roles = $data->roles;
            $permisos = $data->permisos;
            $rouletteSpin = $data->rouletteSpin;
            return view('security.index', compact('roles', 'permisos', 'rouletteSpin'));
        } catch (Exception $e) {
            Log::error("Error en SecurityController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar los datos de seguridad.');
        }
    }

    public function saveRol(Request $request)
    {
        try {
            $data = $this->securityService->saveRol($request);
            $roles = $data->roles;
            return response()->json(["view"=>view('security.components.tabRoles', compact('roles'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en SecurityController: " . $e->getMessage());
        }
    }

    public function verPermisos(Request $request)
    {
<<<<<<< HEAD
        $rol = Role::where('id', $request->id)->first();

        // Si el rol no existe, retornamos respuesta vacía o con error según convenga
        if (!$rol) {
            if ($request->has('format') && $request->format == 'json') {
                return response()->json(['assignedPermissions' => []]);
            }
            return response()->json([
                "view" => view('security.components.tabPermisos', ['permisos' => []])->render()
            ]);
        }

        // Obtenemos los permisos asignados al rol
        $permisos = $rol->permissions;

        // Si se solicita formato JSON, retornamos solo los IDs asignados
        if ($request->has('format') && $request->format == 'json') {
            $assignedPermissions = $permisos->pluck('id')->toArray();
            return response()->json(['assignedPermissions' => $assignedPermissions]);
        }

        // Caso contrario, retornamos la vista renderizada para actualizar la tabla
        return response()->json([
            "view" => view('security.components.tabPermisos', compact('permisos'))->render()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
=======
        try {
            $data = $this->securityService->getPermisos($request);
            $permisos = $data->permisos;
            return response()->json(["view"=>view('security.components.tabPermisos', compact('permisos'))->render()]);
        } catch (Exception $e) {
            Log::error("Error en SecurityController: " . $e->getMessage());
        }
    }

>>>>>>> feature/fix-presentation
    public function asignarPermisoRol(Request $request)
    {
        try {
            $data = $this->securityService->asignarPermisoRol($request);
            $permisos = $data->permisos;
            return response()->json(["view"=>view('security.components.tabPermisos', compact('permisos'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en SecurityController: " . $e->getMessage());
        }
    }

    public function deletePermiso(Request $request)
    {
        try {
            $data = $this->securityService->deletePermiso($request);
            $permisos = $data->permisos;
            return response()->json(["view"=>view('security.components.tabPermisos', compact('permisos'))->render()]);
        } catch (Exception $e) {
            Log::error("Error en SecurityController: " . $e->getMessage());
        }
    }

}
