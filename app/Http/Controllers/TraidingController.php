<?php

namespace App\Http\Controllers;

use App\Models\Traiding;
use App\Http\Controllers\Controller;
use App\Services\TradingService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TraidingController extends Controller
{

    protected $traidingService;

    public function __construct(TradingService $traidingService) {
        $this->traidingService = $traidingService;
    }

    public function saveTraiding(Request $request)
    {
        try {
            $data = $this->traidingService->saveTraiding($request);
            $traidings = $data->traidings;
            return response()->json(["view"=>view('traiding.table.tableTraiding', compact('traidings'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en TraidingController: " . $e->getMessage());
        }
    }

    public function updateTraiding(Request $request)
    {
        try {
            $data = $this->traidingService->updateTraiding($request);
            $traidings = $data->traidings;
            return response()->json(["view"=>view('traiding.table.tableTraiding', compact('traidings'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en TraidingController: " . $e->getMessage());
        }
    }

    public function deleteTraiding(Request $request)
    {
        try {
            $data = $this->traidingService->deleteTraiding($request);
            $traidings = $data->traidings;
            return response()->json(["view"=>view('traiding.table.tableTraiding', compact('traidings'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en TraidingController: " . $e->getMessage());
        }
    }

}
