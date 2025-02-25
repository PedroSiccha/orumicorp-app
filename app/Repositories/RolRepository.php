<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Interfaces\RolRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class RolRepository implements RolRepositoryInterface
{
    public function getAllRoles(): Collection
    {
        try {
            return Role::get();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener los roles: " . $e->getMessage());
        }
    }

    public function getRoleByName(string $name): ?Role
    {
        try {
            return Role::where('name', $name)->firstOrFail();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener el rol: " . $e->getMessage());
        }
    }

    public function findRoleById(int $id): ?Role
    {
        try {
            return Role::find($id);
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener el rol: " . $e->getMessage());
        }
    }
}
