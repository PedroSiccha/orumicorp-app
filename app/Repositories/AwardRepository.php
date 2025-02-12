<?php
namespace App\Repositories;

use App\Interfaces\AwardRepositoryInterface;
use App\Models\Premio;
use Illuminate\Database\Eloquent\Collection;

class AwardRepository implements AwardRepositoryInterface
{
    public function getAwardsByType(int $type): Collection
    {
        return Premio::where('status', true)->where('type', $type)->get();
    }
}
