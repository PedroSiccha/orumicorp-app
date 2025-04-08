<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Contracts\Repositories\SecurityRepositoryInterface;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SecurityRepository implements SecurityRepositoryInterface
{
    public function getAllRolesPaginated(int $limit = 10): LengthAwarePaginator
    {
        try {
            return Role::paginate($limit);
        } catch (Exception $e) {
            Log::error("Error obteniendo los roles paginados: " . $e->getMessage());
            throw new RepositoryException("No se pudieron obtener los roles.");
        }
    }

    public function getAllPermissionsPaginated(int $limit = 10): LengthAwarePaginator
    {
        try {
            return Permission::paginate($limit);
        } catch (Exception $e) {
            Log::error("Error obteniendo los permisos: " . $e->getMessage());
            throw new RepositoryException("No se pudieron obtener los permisos.");
        }
    }

    public function saveRole(array $data): Role
    {
        try {
            return Role::create($data);
        } catch (Exception $e) {
            Log::error("Error creando el rol: " . $e->getMessage());
            throw new RepositoryException("No se pudo crear el rol.");
        }
    }

    public function getRoleById(int $roleId): ?Role
    {
        try {
            return Role::find($roleId);
        } catch (Exception $e) {
            Log::error("Error obteniendo el rol por ID: " . $e->getMessage());
            throw new RepositoryException("No se encontró el rol especificado.");
        }
    }

    public function getPermissionById(int $permissionId): ?Permission
    {
        try {
            return Permission::find($permissionId);
        } catch (Exception $e) {
            Log::error("Error obteniendo el permiso por ID: " . $e->getMessage());
            throw new RepositoryException("No se encontró el permiso.");
        }
    }
}
