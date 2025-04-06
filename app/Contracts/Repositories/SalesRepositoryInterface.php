<?php
namespace App\Contracts\Repositories;

interface SalesRepositoryInterface
{
    public function obtenerTotalesPorMesYArea(int $year);
}
