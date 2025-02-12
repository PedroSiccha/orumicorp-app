<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface PlatformRepositoryInterface
{
    public function getAllPlatforms(): Collection;
}
