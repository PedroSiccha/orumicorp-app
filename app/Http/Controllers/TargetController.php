<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Target;
use App\Services\TargetService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TargetController extends Controller
{

    protected $targetService;

    public function __construct(TargetService $targetService) {
        $this->targetService = $targetService;
    }

    public function saveTarget(Request $request)
    {
        try {
            $data = $this->targetService->saveTarget($request);
            $targets = $data->targets;
            $targetMensual = $data->targetMensual;
            return response()->json(["viewDiv"=>view('profile.components.divTarget', compact('targets'))->render(), "viewTable"=>view('profile.components.tabTarget', compact('targets'))->render(), "viewTotal"=>view('profile.components.tabTotalTarget', compact('targetMensual'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en TargetController: " . $e->getMessage());
        }
    }

    public function updateTarget(Request $request) 
    {
        try {
            $data = $this->targetService->updateTarget($request);
            $targets = $data->targets;
            $targetMensual = $data->targetMensual;
            return response()->json(["viewDiv"=>view('profile.components.divTarget', compact('targets'))->render(), "viewTable"=>view('profile.components.tabTarget', compact('targets'))->render(), "viewTotal"=>view('profile.components.tabTotalTarget', compact('targetMensual'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en TargetController: " . $e->getMessage());
        }
    }

    public function addTarget(Request $request) 
    {
        try {
            $data = $this->targetService->addTarget($request);
            $targets = $data->targets;
            $targetMensual = $data->targetMensual;
            return response()->json(["viewDiv"=>view('profile.components.divTarget', compact('targets'))->render(), "viewTable"=>view('profile.components.tabTarget', compact('targets'))->render(), "viewTotal"=>view('profile.components.tabTotalTarget', compact('targetMensual'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en TargetController: " . $e->getMessage());
        }
    }
}
