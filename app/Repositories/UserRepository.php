<?php
namespace App\Repositories;

use App\Http\Requests\EditUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface
{
    public function createUser(StoreUserRequest $data): ?User
    {
        try {
            return User::create($data);
        } catch (QueryException $e) {
            Log::error("Error UserRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error UserRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getMyId(): int
    {
        try {
            return Auth::user()->id;
        } catch (QueryException $e) {
            Log::error("Error UserRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error UserRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getUser(): ?User
    {
        try {
             return Auth::user();
        } catch (QueryException $e) {
            Log::error("Error UserRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error UserRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function findUserById(int $userId): ?User
    {
        try {
            return User::find($userId);
        } catch (QueryException $e) {
            Log::error("Error UserRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error UserRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function changePassword(User $user, string $password): bool
    {
        try {
            $user->password = Hash::make($password);
            if (!$user->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error UserRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error UserRepository: " . $e->getMessage());
            return false;
        }
    }

    public function updateUser(User $user, EditUserRequest $data): bool
    {
        try {
            $user->fill($data->validated());
            if (!$user->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error UserRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error UserRepository: " . $e->getMessage());
            return false;
        }
    }

    public function deleteUser(int $userId): bool
    {
        try {
            $user = User::find($userId);
            if (!$user) {
                return false;
            }
            if (!$user->delete()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error UserRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error UserRepository: " . $e->getMessage());
            return false;
        }
    }
}
