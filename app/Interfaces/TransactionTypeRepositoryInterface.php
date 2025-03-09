<?php
namespace App\Interfaces;

use App\Http\Requests\EditTransactionTypeRequest;
use App\Http\Requests\StoreTransactionTypeRequest;
use App\Models\TransactionType;
use Illuminate\Database\Eloquent\Collection;

interface TransactionTypeRepositoryInterface
{
    public function getTransactionTypes(): Collection;
    public function saveTransactionType(StoreTransactionTypeRequest $data): ?TransactionType;
    public function findTransactionTypeById(int $transactionTypeId): ?TransactionType;
    public function updateTransactionType(TransactionType $transactionType, StoreTransactionTypeRequest $data): bool;
    public function deleteTransactionType(int $transactionTypeId): bool;
}
