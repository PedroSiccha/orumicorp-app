<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface TraidingRepositoryInterface
{
    public function getAllTraidings(): Collection;
}
