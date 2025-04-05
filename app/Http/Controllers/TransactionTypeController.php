<?php

namespace App\Http\Controllers;

use App\Models\TransactionType;
use App\Http\Controllers\Controller;
use App\Services\TransactionTypeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TransactionTypeController extends Controller
{

    protected $transactionTypeService;

    public function __construct(TransactionTypeService $transactionTypeService) {
        $this->transactionTypeService = $transactionTypeService;
    }

    public function saveTransactionType(Request $request)
    {
        try {
            $data = $this->transactionTypeService->saveTransactionType($request);
            $transactionsType = $data->transactionsType;
            return response()->json(["view"=>view('transactionType.table.tableTransactionType', compact('transactionsType'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en TransactionTypeController: " . $e->getMessage());
        }
    }

    public function updateTransactionType(Request $request)
    {
        try {
            $data = $this->transactionTypeService->updateTransactionType($request);
            $transactionsType = $data->transactionsType;
            return response()->json(["view"=>view('transactionType.table.tableTransactionType', compact('transactionsType'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en TransactionTypeController: " . $e->getMessage());
        }
    }

    public function deleteTransactionType(Request $request)
    {
        try {
            $data = $this->transactionTypeService->deleteTransactionType($request);
            $transactionsType = $data->transactionsType;
            return response()->json(["view"=>view('transactionType.table.tableTransactionType', compact('transactionsType'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en TransactionTypeController: " . $e->getMessage());
        }
    }

}
