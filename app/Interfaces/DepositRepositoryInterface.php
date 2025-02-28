<?php
namespace App\Interfaces;

use App\Models\Area;
use App\Models\BonusAgent;
use App\Models\Deposit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface DepositRepositoryInterface
{
    public function getDeposits(): Collection;
    public function saveDeposit(SaveDepositRequest $request): Deposit;
    // public function getAreas(): Collection;
}
