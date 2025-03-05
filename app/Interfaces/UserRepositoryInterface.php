<?php
namespace App\Interfaces;

use App\Http\Requests\EditUserRequest;
use App\Http\Requests\SaveUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function getMyId(): int;
    public function getUser(): ?User;
    public function findUserById(int $userId): ?User;
    public function createUser(StoreUserRequest $data): ?User;
    public function updateUser(User $user, EditUserRequest $data): bool;
    public function changePassword(User $user, string $password): bool;
    public function deleteUser(int $userId): bool;
}
