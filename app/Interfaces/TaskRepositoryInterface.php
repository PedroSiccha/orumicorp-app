<?php
namespace App\Interfaces;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function getTasks(): Collection;
    public function getAllTasks(): Collection;
    public function getTasksByCustomer(int $customerId): Collection;
    public function saveTask(array $data): Task;
    public function updateTask(Task $task, array $data): bool;
    public function deleteTask(int $taskId): bool;
    public function findTaskById(int $taskId): ?Task;
}
