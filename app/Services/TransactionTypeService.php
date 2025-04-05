<?php
namespace App\Services;

use App\Enums\StatusEnum;
use App\Helpers\ResponseHelper;
use App\Interfaces\TransactionTypeRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TransactionTypeService
{

    protected $transactionTypeRepository;

    public function __construct(
        TransactionTypeRepositoryInterface $transactionTypeRepository
    ) {
      $this->transactionTypeRepository = $transactionTypeRepository;  
    }

    public function saveTransactionType(Request $request)
    {
        $dataTransactionType = [
            'name' => $request->name,
            'description' => $request->description,
            'status' => StatusEnum::ACTIVE->value
        ];
        DB::beginTransaction();
        try { 
            $response = $this->transactionTypeRepository->saveTransactionType($dataTransactionType);
            DB::commit();
            $transactionTypes = $this->transactionTypeRepository->getTransactionTypes();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $transactionTypes]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function updateTransactionType($request)
    {
        $dataTransactionType = [
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status
        ];
        $transactionType = $this->transactionTypeRepository->findTransactionTypeById($request->transactionTypeId);
        DB::beginTransaction();
        try {
            $response = $this->transactionTypeRepository->updateTransactionType($transactionType, $dataTransactionType);
            DB::commit();
            $transactionTypes = $this->transactionTypeRepository->getTransactionTypes();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $transactionTypes]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function deleteTransactionType(int $id)
    {
        DB::beginTransaction();
        try {
            $response = $this->transactionTypeRepository->deleteTransactionType($id);
            $transactionTypes = $this->transactionTypeRepository->getTransactionTypes();
            DB::commit();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $transactionTypes]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }
}