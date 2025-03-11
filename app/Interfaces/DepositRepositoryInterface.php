<?php
namespace App\Interfaces;

use App\Models\Deposit;
use Illuminate\Database\Eloquent\Collection;

interface DepositRepositoryInterface
{
    public function getAllWithRelations(): Collection;
    public function save(array $data): Deposit;
    public function findById(int $depositId): ?Deposit;
    public function delete(int $depositId): bool;
}
