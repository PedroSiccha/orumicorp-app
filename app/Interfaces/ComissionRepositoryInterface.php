<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ComissionRepositoryInterface
{
    public function getActiveCommissions(): Collection;
    public function getAllCommissions(): Collection;
}
