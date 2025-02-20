<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ViewsRepositoryInterface
{
    public function getViewsByClients(int $clientId): Collection;
}
