<?php
namespace App\Interfaces;

use App\Models\Premio;
use Illuminate\Database\Eloquent\Collection;

interface AwardRepositoryInterface
{
    public function getAwardsByType(int $awardType): Collection;
    public function findAwardByOrder(string $orderNumber): ?Premio;
}
