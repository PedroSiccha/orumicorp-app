<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Interfaces\PlatformRepositoryInterface;
use App\Models\Platform;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class PlatformRepository implements PlatformRepositoryInterface
{
    public function getAllPlatforms(): Collection
    {
        try {
            return Platform::all();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener las plataformas: " . $e->getMessage());
        }
    }
}
