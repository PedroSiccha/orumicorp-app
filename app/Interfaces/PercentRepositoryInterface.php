<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface PercentRepositoryInterface
{
    public function getActivePercents(): Collection;
    public function getAllPercents(): Collection;
}
