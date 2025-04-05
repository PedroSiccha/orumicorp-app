<?php
namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class TaskRepository implements TaskRepositoryInterface
{
    public function getTasks(): Collection
    {
        try {
            return Task::with('agent')->get();
        } catch (QueryException $e) {
            Log::error("Error TaskRepository (getTasks): " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getTasksByCustomer(int $customerId): Collection
    {
        try {
            return Task::where('customer_id', $customerId)->with('customer')->get();
        } catch (QueryException $e) {
            Log::error("Error TaskRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getAllTasks(): Collection
    {
        try {
            return Task::all();
        } catch (QueryException $e) {
            Log::error("Error TaskRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveTask(array $data): Task
    {
        try {
            return Task::create($data);
        } catch (QueryException $e) {
            Log::error("Error TaskRepository: " . $e->getMessage());
            throw new Exception("Error al guardar la tarea.");
        }
    }

    public function updateTask(Task $task, array $data): bool
    {
        try {
            $task->fill($data);
            return $task->save();
        } catch (QueryException $e) {
            Log::error("Error TaskRepository: " . $e->getMessage());
            return false;
        }
    }

    public function deleteTask(int $taskId): bool
    {
        try {
            $task = Task::find($taskId);
            if (!$task) {
                return false;
            }
            return $task->delete();
        } catch (QueryException $e) {
            Log::error("Error TaskRepository: " . $e->getMessage());
            return false;
        }
    }

    public function findTaskById(int $taskId): ?Task
    {
        try {
            return Task::find($taskId);
        } catch (QueryException $e) {
            Log::error("Error TaskRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }
}
