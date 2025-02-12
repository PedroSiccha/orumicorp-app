<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ProviderRepositoryInterface
{
    public function getAllProviders(): Collection;
}
