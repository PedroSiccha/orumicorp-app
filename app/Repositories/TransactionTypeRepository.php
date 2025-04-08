<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Contracts\Repositories\TransactionTypeRepositoryInterface;
use App\Models\TransactionType;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class TransactionTypeRepository implements TransactionTypeRepositoryInterface
{
    public function getTransactionTypes(): Collection
    {
        try {
            return TransactionType::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error("Error TransactionTypeRepository@getTransactionTypes: {$e->getMessage()}");
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveTransactionType(array $data): ?TransactionType
    {
        try {
            return TransactionType::create($data);
        } catch (QueryException $e) {
            Log::error("Error TransactionTypeRepository: " . $e->getMessage());
            throw new Exception("Error al guardar el tipo de transacción.");
        }
    }

    public function findTransactionTypeById(int $transactionTypeId): ?TransactionType
    {
        try {
            return TransactionType::where('id', $transactionTypeId)
                                  ->where('status', StatusEnum::ACTIVE->value)
                                  ->first();
        } catch (QueryException $e) {
            Log::error("Error TransactionTypeRepository: " . $e->getMessage());
            throw new Exception("Error al buscar el tipo de transacción.");
        }
    }

    public function updateTransactionType(TransactionType $transactionType, array $data): bool
    {
        try {
            $transactionType->fill($data);
            return $transactionType->save();
        } catch (QueryException $e) {
            Log::error("Error TransactionTypeRepository: " . $e->getMessage());
            return false;
        }
    }

    public function deleteTransactionType(int $transactionTypeId): bool
    {
        try {
            $transactionType = TransactionType::find($transactionTypeId);
            if (!$transactionType) {
                return false;
            }
            return $transactionType->delete();
        } catch (QueryException $e) {
            Log::error("Error TransactionTypeRepository: " . $e->getMessage());
            return false;
        }
    }
}
