<?php
namespace App\Services;

use App\Interfaces\TargetRepositoryInterface;
use Illuminate\Http\Request;

class TargetService
{

    protected $targetRepository;

    public function __construct(
        TargetRepositoryInterface $targetRepository
    ) {
      $this->targetRepository = $targetRepository;  
    }

    public function saveTarget(StoreTargetRequest $request)
    {
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";

        $agent = $this->agentRepository->getAgentByUserId($request->user_id); // Agent::where('user_id', $request->user_id)->first();
        $target = $this->targetRepository->saveTarget($request);
        // $target = new Target();
        // $target->amount = $request->amount;
        // $target->month = date("m");
        // $target->observation = "";
        // $target->status = 1;
        // $target->agent_id = $agent->id;
        // if ($target->save()) {
        //     $title = "Correcto";
        //     $mensaje = "El target se registró correctamente";
        //     $status = "success";
        // } else {
        //     $title = "Error";
        //     $mensaje = "Hubo un error al guardar el target";
        //     $status = "error";
        // }
        $targetMensual = $this->targetRepository->getTargetByMonthAnget(date("m"), $agent->id);
        // $targetMensual = Target::where('status', true)
        //                 ->where('month', date("m"))
        //                 ->where('agent_id', $agent->id)
        //                 ->orderBy("created_at", "asc")
        //                 ->first();
        $targets = $this->targetRepository->getTargetWithDate();

        // return response()->json([
        //     "viewDiv"=>view('profile.components.divTarget', compact('targets'))->render(),
        //     "viewTable"=>view('profile.components.tabTarget', compact('targets'))->render(),
        //     "viewTotal"=>view('profile.components.tabTotalTarget', compact('targetMensual'))->render(),
        //     "title"=>$title,
        //     "text"=>$mensaje,
        //     "status"=>$status
        // ]);
    }

    public function updateTarget(EditTargetRequest $request)
    {
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";

        // $user_id = Auth::user()->id;
        // $agent = Agent::where('id', $user_id)->first();
        $agent = $this->agentRepository->getAgentByUserId($request->user_id);
        $target = $this->targetRepository->updateTarget($request);
        // $target = Target::where('month', date("m"))->where('agent_id', $agent->id)->where('status', 1)->first();
        // $target->amount = $request->amount;
        // if ($target->save()) {
        //     $title = "Correcto";
        //     $mensaje = "El target se actualizó correctamente";
        //     $status = "success";
        // } else {
        //     $title = "Error";
        //     $mensaje = "Hubo un error al actualizar el target";
        //     $status = "error";
        // }
        $targetMensual = $this->targetRepository->getTargetByMonthAnget(date("m"), $agent->id);
        // $targetMensual = Target::where('status', true)
        //                 ->where('month', date("m"))
        //                 ->where('agent_id', $agent->id)
        //                 ->orderBy("created_at", "asc")
        //                 ->first();
        $targets = $this->targetRepository->getTargetWithDate();
        

        // return response()->json([
        //     "viewDiv"=>view('profile.components.divTarget', compact('targets'))->render(),
        //     "viewTable"=>view('profile.components.tabTarget', compact('targets'))->render(),
        //     "viewTotal"=>view('profile.components.tabTotalTarget', compact('targetMensual'))->render(),
        //     "title"=>$title,
        //     "text"=>$mensaje,
        //     "status"=>$status
        // ]);
    }

    public function addTarget(Request $request)
    {
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";

        // $user_id = Auth::user()->id;
        // $agent = Agent::where('id', $user_id)->first();
        $agent = $this->agentRepository->getAgentByUserId($request->user_id);
        $target = $this->targetRepository->updateTarget($request);
        $response = $this->targetRepository->updateAmountTarget($target);

        // $target = Target::where('month', date("m"))->where('agent_id', $agent->id)->where('status', 1)->first();
        // $newAmount = $target->amount + $request->amount;
        // $target->amount = $newAmount;
        // if ($target->save()) {
        //     $title = "Correcto";
        //     $mensaje = "El target se actualizó correctamente";
        //     $status = "success";
        // } else {
        //     $title = "Error";
        //     $mensaje = "Hubo un error al actualizar el target";
        //     $status = "error";
        // }


        $targetMensual = $this->targetRepository->getTargetByMonthAnget(date("m"), $agent->id);
        // $targetMensual = Target::where('status', true)
        //                 ->where('month', date("m"))
        //                 ->where('agent_id', $agent->id)
        //                 ->orderBy("created_at", "asc")
        //                 ->first();
        $targets = $this->targetRepository->getTargetWithDate();

        // return response()->json([
        //     "viewDiv"=>view('profile.components.divTarget', compact('targets'))->render(),
        //     "viewTable"=>view('profile.components.tabTarget', compact('targets'))->render(),
        //     "viewTotal"=>view('profile.components.tabTotalTarget', compact('targetMensual'))->render(),
        //     "title"=>$title,
        //     "text"=>$mensaje,
        //     "status"=>$status
        // ]);
    }
}