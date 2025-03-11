<?php
namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface
{
    public function createUser(array $data): ?User
    {
        try {
            return User::create($data);
        } catch (QueryException $e) {
            Log::error("Error al crear usuario: " . $e->getMessage());
            throw new Exception("No se pudo crear el usuario.");
        }
    }

    public function getMyUserId(): int
    {
        return auth()->id();
    }

    public function getCurrentUser(): ?User
    {
        return auth()->user();
    }

    public function findUserById(int $userId): ?User
    {
        try {
            return User::find($userId);
        } catch (QueryException $e) {
            Log::error("Error al buscar usuario por ID ({$userId}): " . $e->getMessage());
            throw new \Exception("No se encontró el usuario.");
        }
    }

    public function changePassword(User $user, string $password): bool
    {
        try {
            $user->password = bcrypt($password);
            return $user->save();
        } catch (QueryException $e) {
            Log::error("Error al cambiar contraseña del usuario {$user->id}: " . $e->getMessage());
            return false;
        }
    }

    public function updateUser(User $user, array $data): bool
    {
        try {
            $user->fill($data);
            return $user->save();
        } catch (QueryException $e) {
            Log::error("Error al actualizar usuario {$user->id}: " . $e->getMessage());
            return false;
        }
    }

    public function deleteUser(int $userId): bool
    {
        try {
            $user = User::find($userId);

            if (!$user) {
                Log::warning("Usuario con ID {$userId} no encontrado para eliminar.");
                return false;
            }
            return $user->delete();
        } catch (QueryException $e) {
            Log::error("Error al eliminar usuario {$userId}: " . $e->getMessage());
            return false;
        }
    }
}
