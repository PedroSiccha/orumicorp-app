<?php
namespace App\Contracts\Repositories;

use App\Models\TransactionType;
use Illuminate\Database\Eloquent\Collection;

interface TransactionTypeRepositoryInterface
{
    public function getTransactionTypes(): Collection;
    public function saveTransactionType(array $data): ?TransactionType;
    public function findTransactionTypeById(int $transactionTypeId): ?TransactionType;
    public function updateTransactionType(TransactionType $transactionType, array $data): bool;
    public function deleteTransactionType(int $transactionTypeId): bool;
}
