<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Interfaces\PriorityRepositoryInterface;
use App\Models\Priority;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class PriorityRepository implements PriorityRepositoryInterface
{
    public function getAllPriorities(): Collection
    {
        try {
            return Priority::where('status', true)->get();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener las prioridades: " . $e->getMessage());
        }
    }
}
