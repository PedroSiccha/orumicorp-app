<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Interfaces\ProviderRepositoryInterface;
use App\Models\Provider;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ProviderRepository implements ProviderRepositoryInterface
{
    public function getAllProviders(): Collection
    {
        try {
            return Provider::all();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener los proveedores: " . $e->getMessage());
        }
    }
}
