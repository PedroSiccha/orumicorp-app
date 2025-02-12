<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Interfaces\ConfigurationRepositoryInterface;
use App\Models\Configuration;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ConfigurationRepository implements ConfigurationRepositoryInterface
{
    public function getUserConfigurations(int $userId, string $view): Collection
    {
        try {
            return Configuration::where('user_id', $userId)
                            ->where('view', $view)
                            ->pluck('status', 'name')
                            ->get();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener las configuraciones: " . $e->getMessage());
        }

    }

    public function ensureConfigurationExists(int $userId, string $view, string $name): void
    {
        try {
            $config = Configuration::where('user_id', $userId)
                               ->where('view', $view)
                               ->where('name', $name)
                               ->first();

            if (!$config) {
                Configuration::create([
                    'user_id' => $userId,
                    'view' => $view,
                    'name' => $name,
                    'status' => 'active'
                ]);
                Log::info("Configuración creada: $name para el usuario $userId.");
            }
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener las configuraciones existentes: " . $e->getMessage());
        }

    }
}
