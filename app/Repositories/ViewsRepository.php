<?php
namespace App\Repositories;

use App\Http\Requests\StoreViewRequest;
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
        } catch (QueryException $e) {
            Log::error("Error ViewsRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ViewsRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveViews(StoreViewRequest $data): Views
    {
        try {
            return Views::create($data);
        } catch (QueryException $e) {
            Log::error("Error ViewsRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ViewsRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }
}
