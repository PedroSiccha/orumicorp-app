<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Interfaces\EventRepositoryInterface;
use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class EventRepository implements EventRepositoryInterface
{
    public function getEventsByCustomer(int $clientId): Collection
    {
        try {
            return Task::with('customer')->where('customer_id', $clientId)->get();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener los eventos del cliente {$clientId}: " . $e->getMessage());
        }
        
    }
}
