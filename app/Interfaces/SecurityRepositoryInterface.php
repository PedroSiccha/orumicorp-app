<?php
namespace App\Interfaces;

use App\Http\Requests\StoreRolRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

interface SecurityRepositoryInterface
{
    public function getRoles(int $pagination): LengthAwarePaginator;
    public function getPermission(int $pagination): LengthAwarePaginator;
    public function saveRol(StoreRolRequest $data): Role;
    public function getRolesById(int $rolesId): ?Role;
    public function getPermiPermissionById(int $permissionId): ?Permission;
}
