<?php
namespace App\Contracts\Repositories;

use App\Models\Comunications;
use Illuminate\Database\Eloquent\Collection;

interface ComunicationRepositoryInterface
{
    public function getComunicationsByCustomer(int $customerId, array $relations = []): Collection;
    public function getComunicationsByAgent(int $agentId): Collection;
    public function findById(int $comunicationId): ?Comunications;
    public function save(array $data): Comunications;
    public function update(Comunications $comunication, array $data): bool;
    public function delete(int $comunicationId): bool;
    public function getLocationByCustomer(int $clientId): Collection;
}
