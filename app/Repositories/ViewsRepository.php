<?php
namespace App\Repositories;

use App\Interfaces\ViewsRepositoryInterface;
use App\Models\Views;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ViewsRepository implements ViewsRepositoryInterface
{
    public function getViewsByClients(int $clientId): Collection
    {
        try {
            return Views::with('agent')->where('customer_id', $clientId)->get();
        } catch (QueryException  $e) {
            Log::error("Error obteniendo vistas por cliente (ID: {$clientId}): " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveViews(array $data): Views
    {
        try {
            return Views::create($data);
        } catch (QueryException  $e) {
            Log::error("Error al guardar la vista: " . $e->getMessage());
            throw new Exception("Error al guardar la vista.");
        }
    }
}
