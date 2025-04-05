<?php
namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getMyUserId(): int;
    public function getCurrentUser(): ?User;
    public function findUserById(int $userId): ?User;
    public function createUser(array $data): ?User;
    public function updateUser(User $user, array $data): bool;
    public function changePassword(User $user, string $password): bool;
    public function deleteUser(int $userId): bool;
}
