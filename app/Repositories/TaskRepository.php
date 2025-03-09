<?php
namespace App\Repositories;

use App\Http\Requests\EditTaskRequest;
use App\Http\Requests\StoreTaskRequest;
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
            Log::error("Error TaskRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error TaskRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getTaskWithCustomer(int $customerId): Collection
    {
        try {
             return Task::with('customer')->find($customerId);
       } catch (QueryException $e) {
           Log::error("Error TaskRepository: " . $e->getMessage());
           throw new Exception("No se encontraron resultados para los filtros aplicados.");
       } catch (Exception $e) {
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
        } catch (Exception $e) {
            Log::error("Error TaskRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveTask(StoreTaskRequest $data): Task
    {
        try {
            return Task::create($data);
        } catch (QueryException $e) {
            Log::error("Error TaskRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error TaskRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function updateTask(Task $task, StoreTaskRequest $data): bool
    {
        try {
            $task->fill($data->validated());
            if (!$task->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error TaskRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
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
            if (!$task->delete()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error TaskRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
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
        } catch (Exception $e) {
            Log::error("Error TaskRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }
}
