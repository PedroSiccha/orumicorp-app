<?php
namespace App\Repositories;

use App\Interfaces\SecurityRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SecurityRepository implements SecurityRepositoryInterface
{
    public function getRoles(int $pagination): LengthAwarePaginator
    {
        try {
            return Role::paginate($pagination);
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getPermission(int $pagination): LengthAwarePaginator
    {
        try {
            return Permission::paginate($pagination);
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveRol(StoreRolRequest $data): Role
    {
        try {
            // return $customer->delete();
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getRolesById(int $rolesId): Role
    {
        try {
            // return $customer->delete();
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getPermiPermissionById(int $permissionId): Permission
    {
        try {
            // return $customer->delete();
        } catch (QueryException $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error AgentRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }
}
