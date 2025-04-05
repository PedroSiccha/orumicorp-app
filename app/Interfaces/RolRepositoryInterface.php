<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

interface RolRepositoryInterface
{
    public function getAll(): Collection;
    public function findByName(string $name): ?Role;
    public function findById(int $roleId): ?Role;
}
