<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Http\Requests\SaveUserRequest;
use App\Interfaces\RolRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class UserRepository implements UserRepositoryInterface
{
    public function createUser(SaveUserRequest $data): ?User
    {
        try {
            return User::create($data);
        } catch (Exception $e) {
            throw new RepositoryException("Error al crear el usuario: " . $e->getMessage());
        }
    }
}
