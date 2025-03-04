<?php
namespace App\Interfaces;

use App\Http\Requests\EditTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use App\Models\Traiding;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function getTasks(): Collection;
    public function getAllTasks(): Collection;
    public function getTaskWithCustomer(int $customerId): Collection;
    public function saveTask(StoreTaskRequest $data): Task;
    public function updateTask(Task $task, EditTaskRequest $data): bool;
    public function deleteTask(int $taskId): bool;
}
