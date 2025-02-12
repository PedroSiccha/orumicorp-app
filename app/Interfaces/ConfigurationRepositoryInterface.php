<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ConfigurationRepositoryInterface
{
    public function getUserConfigurations(int $userId, string $view): Collection;
    public function ensureConfigurationExists(int $userId, string $view, string $name): void;
}
