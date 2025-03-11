<?php
namespace App\Interfaces;

use App\Models\Configuration;
use Illuminate\Database\Eloquent\Collection;

interface ConfigurationRepositoryInterface
{
    public function getUserConfigurations(int $userId, string $view): Collection;
    public function ensureConfigurationExists(int $userId, string $view, string $name): Configuration;
    public function updateConfigurationStatus(int $configId, string $status): bool;
    public function delete(int $configurationId): bool;
}
