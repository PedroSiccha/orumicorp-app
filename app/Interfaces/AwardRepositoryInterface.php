<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface AwardRepositoryInterface
{
    public function getAwardsByType(int $type): Collection;
    public function findAwardByName(string $data): Collection;
}
