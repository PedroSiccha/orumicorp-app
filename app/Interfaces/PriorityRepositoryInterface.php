<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface PriorityRepositoryInterface
{
    public function getAllPriorities(): Collection;
}
