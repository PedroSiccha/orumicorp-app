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
    // public function saveTarget(Request $request)
    // {
    //     $title = "Error";
    //     $mensaje = "Error desconocido";
    //     $status = "error";

    //     $agent = Agent::where('user_id', $request->user_id)->first();

    //     $target = new Target();
    //     $target->amount = $request->amount; 
    //     $target->month = date("m");
    //     $target->observation = "";
    //     $target->status = 1;
    //     $target->agent_id = $agent->id;
    //     if ($target->save()) {
    //         $title = "Correcto";
    //         $mensaje = "El target se registró correctamente";
    //         $status = "success";
    //     } else {
    //         $title = "Error";
    //         $mensaje = "Hubo un error al guardar el target";
    //         $status = "error";
    //     }

    //     $targetMensual = Target::where('status', true)
    //                     ->where('month', date("m"))
    //                     ->where('agent_id', $agent->id)
    //                     ->orderBy("created_at", "asc")
    //                     ->first();

    //     $targets = Target::select('id', 'amount', 'agent_id')
    //                     ->selectRaw("MONTHNAME(CONCAT('2024-', month, '-01')) AS mes")
    //                     ->get();

    //     return response()->json([
    //         "viewDiv"=>view('profile.components.divTarget', compact('targets'))->render(),
    //         "viewTable"=>view('profile.components.tabTarget', compact('targets'))->render(),
    //         "viewTotal"=>view('profile.components.tabTotalTarget', compact('targetMensual'))->render(),
    //         "title"=>$title,
    //         "text"=>$mensaje,
    //         "status"=>$status
    //     ]);
    // }

    public function saveTarget(Request $request)
    {
        $codeAgent = $request->dni; // viene del input del modal
        $amount = $request->amount;

        $agent = Agent::where('code_voiso', $codeAgent)->first();

        if (!$agent) {
            return response()->json([
                'title' => 'Error',
                'text' => 'Agente no encontrado.',
                'status' => 'error'
            ]);
        }

        try {
            // Guardar nuevo target
            $target = new Target();
            $target->amount = $amount;
            $target->month = date("m");
            $target->observation = "";
            $target->status = 1;
            $target->agent_id = $agent->id;
            $target->save();

            $title = "Correcto";
            $mensaje = "El target se registró correctamente";
            $status = "success";
        } catch (Exception $e) {
            return response()->json([
                'title' => 'Error',
                'text' => 'Ocurrió un error: ' . $e->getMessage(),
                'status' => 'error'
            ]);
        }

        // Recargar parciales después de guardar
        // $targetMensual = Target::where('status', true)
        //                 ->where('month', date("m"))
        //                 ->where('agent_id', $agent->id)
        //                 ->orderBy("created_at", "asc")
        //                 ->first();

        // $targets = Target::select('id', 'amount', 'agent_id')
        //             ->selectRaw("MONTHNAME(CONCAT(YEAR(CURDATE()), '-', month, '-01')) AS mes")
        //             ->get();

        return response()->json([
            // "viewDiv" => view('profile.components.divTarget', compact('targets'))->render(),
            // "viewTable" => view('profile.components.tabTarget', compact('targets'))->render(),
            // "viewTotal" => view('profile.components.tabTotalTarget', compact('targetMensual'))->render(),
            "title" => $title,
            "text" => $mensaje,
            "status" => $status
        ]);
    }


    public function updateTarget(Request $request) {

        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        $user_id = Auth::user()->id;
        $agent = Agent::where('id', $user_id)->first();

        $target = Target::where('month', date("m"))->where('agent_id', $agent->id)->where('status', 1)->first();
        $target->amount = $request->amount;
        if ($target->save()) {
            $title = "Correcto";
            $mensaje = "El target se actualizó correctamente";
            $status = "success";
        } else {
            $title = "Error";
            $mensaje = "Hubo un error al actualizar el target";
            $status = "error";

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
