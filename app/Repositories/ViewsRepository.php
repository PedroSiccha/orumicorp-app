<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Interfaces\ViewsRepositoryInterface;
use App\Models\Views;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ViewsRepository implements ViewsRepositoryInterface
{
    public function getViewsByClients(int $clientId): Collection
    {
        try {
            return Views::with('agent')->where('customer_id', $clientId)->get();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener las vistas del cliente {$clientId}: " . $e->getMessage());
        }
        
    }
}
