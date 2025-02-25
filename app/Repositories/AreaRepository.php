<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Interfaces\AreaRepositoryInterface;
use App\Models\Area;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class AreaRepository implements AreaRepositoryInterface
{
    public function getAllAreas(): Collection
    {
        try {
            return Area::where('status', true)->get();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener las áreas: " . $e->getMessage());
        }
    }
}
