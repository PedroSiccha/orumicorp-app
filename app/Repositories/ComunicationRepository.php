<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Contracts\Repositories\ComunicationRepositoryInterface;
use App\Models\Comunications;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Throwable;

class ComunicationRepository implements ComunicationRepositoryInterface
{
    public function getComunicationsByCustomer(int $customerId, array $relations = []): Collection
    {
        try {
            return Comunications::with($relations)
                ->where('customer_id', $customerId)
                ->orderBy('date', 'desc')
                ->get();
        } catch (QueryException $e) {
            Log::error('ComunicationRepository@getComunicationsByCustomer: ' . $e->getMessage());
            throw new Exception('Error al obtener comunicaciones del cliente.');
        }
    }

    public function getComunicationsByAgent(int $agentId): Collection
    {
        try {
            return Comunications::where('agent_id', $agentId)->get();
        } catch (QueryException $e) {
            Log::error('ComunicationRepository@getComunicationsByAgent: ' . $e->getMessage());
            throw new Exception('Error al obtener comunicaciones por agente.');
        }
    }

    public function findById(int $comunicationId): ?Comunications
    {
        try {
            return Comunications::find($comunicationId);
        } catch (QueryException $e) {
            Log::error('ComunicationRepository@findById: ' . $e->getMessage());
            throw new Exception('Error al buscar comunicación.');
        }
    }

    public function save(array $data): Comunications
    {
        try {
            return Comunications::create($data);
        } catch (QueryException $e) {
            Log::error('ComunicationRepository@save: ' . $e->getMessage());
            throw new Exception('Error al guardar comunicación.');
        }
    }

    public function update(Comunications $comunication, array $data): bool
    {
        try {
            return $comunication->update($data);
        } catch (QueryException $e) {
            Log::error('ComunicationRepository@update: ' . $e->getMessage());
            throw new Exception('Error al actualizar comunicación.');
        }
    }

    public function delete(int $comunicationId): bool
    {
        try {
            $comunication = Comunications::find($comunicationId);
            if (!$comunication) {
                return false;
            }
            return $comunication->delete();
        } catch (QueryException $e) {
            Log::error('ComunicationRepository@delete: ' . $e->getMessage());
            throw new Exception('Error al eliminar comunicación.');
        }
    }

    public function getLocationByCustomer(int $clientId): Collection
    {
        try {
            $locations = Comunications::where('status', StatusEnum::ACTIVE->value)
                ->where('customer_id', $clientId)
                ->get();
            if ($locations->isEmpty()) {
                Log::warning("No se encontraron ubicaciones para el cliente ID: {$clientId}.");
            }
            return $locations;
        } catch (Throwable $e) {
            Log::error("Error en ComunicationRepository - getLocationByCustomer: " . $e->getMessage());
            throw new Exception("Error al obtener ubicaciones del cliente ID: {$clientId}.");
        }
    }

}
