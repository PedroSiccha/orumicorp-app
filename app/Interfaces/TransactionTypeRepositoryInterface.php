<?php
namespace App\Interfaces;

use App\Models\Area;
use App\Models\BonusAgent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface TransactionTypeRepositoryInterface
{
    public function getTransactionTypes(): Collection;
    // public function saveBonus(BonusAgentRequest $request): BonusAgent;
    // public function getAreas(): Collection;
}
