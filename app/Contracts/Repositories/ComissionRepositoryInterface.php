<?php
namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface ComissionRepositoryInterface
{
    public function getActiveCommissions(): Collection;
    public function getAllCommissions(): Collection;
}
