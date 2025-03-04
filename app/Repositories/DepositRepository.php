<?php
namespace App\Repositories;

use App\Http\Requests\StoreDepositRequest;
use App\Interfaces\DepositRepositoryInterface;
use App\Models\Deposit;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class DepositRepository implements DepositRepositoryInterface
{
    public function getDeposits(): Collection
    {
        try {
             return Deposit::with('customer')->with(['agent', 'user'])->get();
        } catch (QueryException $e) {
            Log::error("Error DepositRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error DepositRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveDeposit(StoreDepositRequest $data): Deposit
    {
        try {
            return Deposit::create($data);
        } catch (QueryException $e) {
            Log::error("Error DepositRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error DepositRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }
}
