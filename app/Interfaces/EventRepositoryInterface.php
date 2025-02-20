<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface EventRepositoryInterface
{
    public function getEventsByCustomer(int $clientId): Collection;
}
