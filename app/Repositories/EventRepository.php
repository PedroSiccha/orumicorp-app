<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Contracts\Repositories\EventRepositoryInterface;
use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class EventRepository implements EventRepositoryInterface
{
    public function getEventsByCustomer(int $customerId): Collection
    {
        try {
            return Task::with('customer')
                       ->where('customer_id', $customerId)
                       ->get();
        } catch (QueryException $e) {
            Log::error('EventRepository@getEventsByCustomer: ' . $e->getMessage());
            throw new RepositoryException("Error al obtener los eventos del cliente.");
        }
    }

    public function findEventById(int $eventId): ?Task
    {
        try {
            return Task::find($eventId);
        } catch (QueryException $e) {
            Log::error('EventRepository@findEventById: ' . $e->getMessage());
            throw new RepositoryException('Error al buscar el evento.');
        }
    }
}
