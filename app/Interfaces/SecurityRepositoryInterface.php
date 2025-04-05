<?php
namespace App\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

interface SecurityRepositoryInterface
{
    public function getAllRolesPaginated(int $limit = 10): LengthAwarePaginator;
    public function getAllPermissionsPaginated(int $limit = 10): LengthAwarePaginator;
    public function saveRole(array $data): Role;
    public function getRoleById(int $roleId): ?Role;
    public function getPermissionById(int $permissionId): ?Permission;
}
