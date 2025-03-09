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
use Illuminate\Validation\ValidationException;

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
            $user = $this->userRepository->getUser();
            $agent = $this->agentRepository->getMyAgent();
            $rouletteSpin = $agent->number_turns ?: 0;
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $agent]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function saveRol(Request $request)
    {
        DB::beginTransaction();
        try {
            $role = $this->securityRepository->saveRol($request);
            DB::commit();
            $roles = $this->securityRepository->getRoles(10);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $roles]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function getPermisos(Request $request)
    {
        try {
            $rol = $this->securityRepository->getRolesById($request->id);
            if ($rol) {
                $permisos = $rol->permissions;
            }
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $permisos]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function asignarPermisoRol(Request $request)
    {
        try {
            $rol = $this->securityRepository->getRolesById($request->rol_id);
            for ($i=0; $i < count($request->idPermiso) ; $i++) {
                $permiso = $this->securityRepository->getPermiPermissionById($request->idPermiso);
                $rol->givePermissionTo($permiso);
            }
            if ($rol) {
                $permisos = $rol->permissions;
            }
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $permisos]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function deletePermiso(Request $request)
    {
        try {
            $rol = $this->securityRepository->getRolesById($request->idRol);
            $permiso = $this->securityRepository->getPermiPermissionById($request->idPermiso);
            $rol->revokePermissionTo($permiso);
            if ($rol) {
                $permisos = $rol->permissions;
            }
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $permisos]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }
}