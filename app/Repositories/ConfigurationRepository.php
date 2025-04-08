<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Contracts\Repositories\ConfigurationRepositoryInterface;
use App\Models\Configuration;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ConfigurationRepository implements ConfigurationRepositoryInterface
{
    public function getUserConfigurations(int $userId, string $view): Collection
    {
        try {
            return Configuration::where('user_id', $userId)
                ->where('view', $view)
                ->get(['name', 'status']);
        } catch (QueryException $e) {
            Log::error('ConfigurationRepository@getUserConfigurations: ' . $e->getMessage());
            throw new RepositoryException("Error al obtener las configuraciones del usuario.");
        }
    }

    public function ensureConfigurationExists(int $userId, string $view, string $name): Configuration
    {
        try {
            return Configuration::firstOrCreate(
                ['user_id' => $userId, 'view' => $view, 'name' => $name],
                ['status' => 'active']
            );
        } catch (QueryException $e) {
            Log::error('ConfigurationRepository@ensureConfigurationExists: ' . $e->getMessage());
            throw new RepositoryException("Error al asegurar la existencia de la configuración.");
        }
    }

    public function updateConfigurationStatus(int $configId, string $status): bool
    {
        try {
            return Configuration::where('id', $configId)->update(['status' => $status]) > 0;
        } catch (QueryException $e) {
            Log::error('ConfigurationRepository@updateStatus: ' . $e->getMessage());
            throw new RepositoryException('Error al actualizar el estado de configuración.');
        }
    }

    public function delete(int $configurationId): bool
    {
        try {
            return Configuration::destroy($configurationId) > 0;
        } catch (QueryException $e) {
            Log::error('ConfigurationRepository@delete: ' . $e->getMessage());
            throw new RepositoryException('Error al eliminar configuración.');
        }
    }
}
