<?php
namespace App\Interfaces;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface EventRepositoryInterface
{
    public function getEventsByCustomer(int $customerId): Collection;
    public function findEventById(int $eventId): ?Task;
}
