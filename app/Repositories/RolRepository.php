<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Interfaces\RolRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RolRepository implements RolRepositoryInterface
{
    public function getAll(): Collection
    {
        try {
            return Role::all();
        } catch (QueryException $e) {
            Log::error('RoleRepository@getAll: ' . $e->getMessage());
            throw new RepositoryException('Error al obtener roles.');
        }
    }

    public function findByName(string $name): ?Role
    {
        try {
            return Role::where('name', $name)->first();
        } catch (QueryException $e) {
            Log::error('RoleRepository@findByName: ' . $e->getMessage());
            throw new RepositoryException('Error al obtener el rol por nombre.');
        }
    }

    public function findById(int $roleId): ?Role
    {
        try {
            return Role::find($roleId);
        } catch (QueryException $e) {
            Log::error('RoleRepository@findById: ' . $e->getMessage());
            throw new RepositoryException('Error al buscar el rol.');
        }
    }
}
