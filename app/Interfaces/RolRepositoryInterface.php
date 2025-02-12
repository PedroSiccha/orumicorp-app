<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

interface RolRepositoryInterface
{
    public function getAllRoles(): Collection;
    public function getRoleByName(string $name): ?Role;
}
