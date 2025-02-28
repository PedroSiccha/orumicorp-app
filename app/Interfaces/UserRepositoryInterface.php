<?php
namespace App\Interfaces;

use App\Http\Requests\SaveUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function getUserById(): ?User;
    public function getMyId(): int;

    public function findUserById(int $userId): ?User;

    public function createUser(SaveUserRequest $data): ?User;
    
    public function changePassword(User $user, string $password): User;
    
    public function deleteUser(int $userId): bool;
    

}
