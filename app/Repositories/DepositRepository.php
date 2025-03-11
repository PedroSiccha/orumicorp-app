<?php
namespace App\Repositories;

use App\Interfaces\DepositRepositoryInterface;
use App\Models\Deposit;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class DepositRepository implements DepositRepositoryInterface
{
    public function getAllWithRelations(): Collection
    {
        try {
            return Deposit::with(['customer', 'agent', 'user'])->get();
        } catch (QueryException $e) {
            Log::error('DepositRepository@getAllWithRelations: ' . $e->getMessage());
            throw new Exception('Error al obtener depósitos.');
        }
    }

    public function save(array $data): Deposit
    {
        try {
            return Deposit::create($data);
        } catch (QueryException $e) {
            Log::error('DepositRepository@save: ' . $e->getMessage());
            throw new Exception('Error al guardar depósito.');
        }
    }

    public function findById(int $depositId): ?Deposit
    {
        try {
            return Deposit::find($depositId);
        } catch (QueryException $e) {
            Log::error('DepositRepository@findById: ' . $e->getMessage());
            throw new Exception('Error al buscar depósito.');
        }
    }

    public function delete(int $depositId): bool
    {
        try {
            return Deposit::destroy($depositId) > 0;
        } catch (QueryException $e) {
            Log::error('DepositRepository@delete: ' . $e->getMessage());
            throw new Exception('Error al eliminar depósito.');
        }
    }
}
