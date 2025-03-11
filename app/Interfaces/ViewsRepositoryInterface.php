<?php
namespace App\Interfaces;

use App\Models\Views;
use Illuminate\Database\Eloquent\Collection;

interface ViewsRepositoryInterface
{
    public function getViewsByClients(int $clientId): Collection;
    public function saveViews(array $data): Views;
}
