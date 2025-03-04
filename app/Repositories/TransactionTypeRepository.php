<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Http\Requests\EditTransactionTypeRequest;
use App\Http\Requests\StoreTransactionTypeRequest;
use App\Interfaces\TransactionTypeRepositoryInterface;
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
            Log::error("Error TransactionTypeRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error TransactionTypeRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveTransactionType(StoreTransactionTypeRequest $data): ?TransactionType
    {
        try {
            return TransactionType::create($data);
        } catch (QueryException $e) {
            Log::error("Error TransactionTypeRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error TransactionTypeRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function findTransactionTypeById(int $transactionTypeId): ?TransactionType
    {
        try {
            return TransactionType::where('status', StatusEnum::ACTIVE->value)->where('id', $transactionTypeId)->first();
        } catch (QueryException $e) {
            Log::error("Error TransactionTypeRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error TransactionTypeRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function updateTransactionType(TransactionType $transactionType, EditTransactionTypeRequest $data): bool
    {
        try {
            $transactionType->fill($data->validated());
            if (!$transactionType->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error TransactionTypeRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
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
            if (!$transactionType->delete()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error TransactionTypeRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error TransactionTypeRepository: " . $e->getMessage());
            return false;
        }
    }
}
