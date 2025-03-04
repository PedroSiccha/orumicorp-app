<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Http\Requests\EditComunicationRequest;
use App\Http\Requests\StoreComunicationRequest;
use App\Interfaces\ComunicationRepositoryInterface;
use App\Models\Comunications;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ComunicationRepository implements ComunicationRepositoryInterface
{
    public function getLocationByCustomer(int $clientId): Collection
    {
        try {
            return Comunications::where('status', StatusEnum::ACTIVE->value)->where('customer_id', $clientId)->get();
        } catch (QueryException $e) {
            Log::error("Error ComunicationRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ComunicationRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getComunicationsByClient(int $clientId): Collection
    {
        try {
             return Comunications::where('customer_id', $clientId)->get();
        } catch (QueryException $e) {
            Log::error("Error ComunicationRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ComunicationRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function updateComunication(Comunications $comunication, EditComunicationRequest $data): bool
    {
        try {
            $comunication->fill($data->validated());
            if (!$comunication->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error ComunicationRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error ComunicationRepository: " . $e->getMessage());
            return false;
        }
    }

    public function saveComunication(StoreComunicationRequest $data): Comunications
    {
        try {
            return Comunications::create($data);
        } catch (QueryException $e) {
            Log::error("Error ComunicationRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ComunicationRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getComunicationsByAgent(int $agentId): Collection
    {
        try {
             return Comunications::where('agent_id', $agentId)->get();
        } catch (QueryException $e) {
            Log::error("Error ComunicationRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ComunicationRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getComunicationsbyCustomer(int $clientId): Collection
    {
        try {
            return Comunications::where('customer_id', $clientId)->with(['agent', 'customer'])->orderBy('date', 'desc')->get();
        } catch (QueryException $e) {
            Log::error("Error ComunicationRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ComunicationRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }
}
