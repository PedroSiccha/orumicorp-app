<?php
namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\SecurityRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        try {
            $user = $this->userRepository->getCurrentUser();
            $agent = $this->agentRepository->getMyAgent();
            $rouletteSpin = $agent->number_turns ?: 0;
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $agent]);
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function saveRol($request)
    {
        DB::beginTransaction();
        try {
            // Obtener los datos del request
            $data = [
                'name' => $request->name,
                'description' => $request->description
            ];

            // Guardar rol usando el repositorio
            $role = $this->securityRepository->saveRole($data);

            // Confirmar la transacción
            DB::commit();

            return ResponseHelper::success('Rol guardado correctamente.', ['response' => $role]);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en saveRol: " . $e->getMessage());
            return ResponseHelper::error('Error al guardar el rol.');
        }
    }




    public function getPermisos($request)
    {
        try {
            // Buscar el rol por ID
            $rol = $this->securityRepository->getRoleById($request->id);

            // Si existe el rol, obtener permisos; si no, devolver array vacío
            $permisos = $rol ? $rol->permissions : [];

            return ResponseHelper::success('Permisos obtenidos correctamente.', ['response' => $permisos]);

        } catch (Exception $e) {
            Log::error("Error en getPermisos: " . $e->getMessage());
            return ResponseHelper::error('Error al obtener los permisos del rol.');
        }
    }


    public function asignarPermisoRol(Request $request)
    {
        DB::beginTransaction(); // Iniciamos la transacción

        try {
            // Buscar el rol
            $rol = $this->securityRepository->getRoleById($request->rol_id);

            // Validar si el rol existe
            if (!$rol) {
                return ResponseHelper::error('El rol especificado no existe.');
            }

            // Asignar cada permiso al rol
            foreach ($request->idPermiso as $permisoId) {
                $permiso = $this->securityRepository->getPermissionById($permisoId);
                
                if ($permiso) {
                    $rol->givePermissionTo($permiso);
                }
            }

            // Obtener los permisos actualizados
            $permisos = $rol->permissions;

            DB::commit(); // Confirmar la transacción

            return ResponseHelper::success('Permisos asignados correctamente.', ['response' => $permisos]);

        } catch (Exception $e) {
            DB::rollBack(); // Revertir cambios en caso de error
            Log::error("Error en asignarPermisoRol: " . $e->getMessage());
            return ResponseHelper::error('Error al asignar permisos al rol.');
        }
    }


    public function deletePermiso(Request $request)
    {
        DB::beginTransaction(); // Iniciar la transacción

        try {
            // Buscar el rol y validar que exista
            $rol = $this->securityRepository->getRoleById($request->idRol);
            if (!$rol) {
                return ResponseHelper::error('El rol especificado no existe.');
            }

            // Buscar el permiso y validar que exista
            $permiso = $this->securityRepository->getPermissionById($request->idPermiso);
            if (!$permiso) {
                return ResponseHelper::error('El permiso especificado no existe.');
            }

            // Revocar el permiso si el rol lo tiene
            if ($rol->hasPermissionTo($permiso)) {
                $rol->revokePermissionTo($permiso);
            }

            // Obtener los permisos actualizados
            $permisos = $rol->permissions;

            DB::commit(); // Confirmar la transacción

            return ResponseHelper::success('Permiso eliminado correctamente.', ['response' => $permisos]);

        } catch (Exception $e) {
            DB::rollBack(); // Revertir cambios en caso de error
            Log::error("Error en deletePermiso: " . $e->getMessage());
            return ResponseHelper::error('Error al eliminar el permiso.');
        }
    }

}