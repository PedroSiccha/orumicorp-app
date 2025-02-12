<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Interfaces\TraidingRepositoryInterface;
use App\Models\Traiding;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class TraidingRepository implements TraidingRepositoryInterface
{
    public function getAllTraidings(): Collection
    {
        try {
            return Traiding::all();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener los traiding: " . $e->getMessage());
        }
    }
}
