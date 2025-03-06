<?php
namespace App\Interfaces;

use App\Http\Requests\StoreComunicationRequest;
use App\Models\Comunications;
use Illuminate\Database\Eloquent\Collection;

interface ComunicationRepositoryInterface
{
    public function getLocationByCustomer(int $clientId): Collection;
    public function getComunicationsByClient(int $clientId): Collection;
    public function findComunicationById(int $comunicationId): ?Comunications;
    public function updateComunication(Comunications $comunication, StoreComunicationRequest $data): bool;
    public function saveComunication(StoreComunicationRequest $data): Comunications;
    public function getComunicationsByAgent(int $agentId): Collection;
    public function getComunicationsbyCustomer(int $clientId): Collection;
}
