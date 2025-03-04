<?php
namespace App\Services;

use App\Interfaces\TraidingRepositoryInterface;
use Illuminate\Http\Request;

class TradingService
{

    protected $traidingRepository;

    public function __construct(
        TraidingRepositoryInterface $traidingRepository
    ) {
      $this->traidingRepository = $traidingRepository;  
    }

    public function saveTraiding(StoreTraidingRequest $request)
    {
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";

        // try {
        $response = $this->traidingRepository->saveTraiding($request);

        //     $trading = new Traiding();
        //     $trading->code = $request->code;
        //     $trading->description = $request->description;
        //     $trading->status = 'active';
        //     if ($trading->save()) {
        //         $title = "Correcto";
        //         $mensaje = "El trading se registró correctamente";
        //         $status = "success";
        //     }

        // } catch (ValidationException $e) {
        //     $title = "Error";
        //     $mensaje = $e->getMessage();
        //     $status = "error";
        // } catch (Exception $e) {
        //     $title = "Error";
        //     $mensaje = $e->getMessage();
        //     $status = "error";
        // }

        $traidings = $this->traidingRepository->getTraidings();

        // return response()->json(["view"=>view('traiding.table.tableTraiding', compact('traidings'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }

    public function updateTraiding(EditTraidingRequest $request)
    {
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";

        // try {
        $response = $this->traidingRepository->updateTraiding($request);

        //     $trading = Traiding::find($request->id);
        //     $trading->code = $request->code;
        //     $trading->description = $request->description;
        //     $trading->status = $request->status;

        //     if ($trading->save()) {
        //         $title = "Correcto";
        //         $mensaje = "Se actualizó su trading correctamente";
        //         $status = "success";
        //     } else {
        //         $title = "Error";
        //         $mensaje = "Hubo un error al actualizar su trading";
        //         $status = "error";
        //     }

        // } catch (ValidationException $e) {
        //     $title = "Error";
        //     $mensaje = $e->getMessage();
        //     $status = "error";
        // } catch (Exception $e) {
        //     $title = "Error";
        //     $mensaje = "Verificar los datos del registro";
        //     $status = "error";
        // }

        $traidings = $this->traidingRepository->getTraidings();

        // return response()->json(["view"=>view('traiding.table.tableTraiding', compact('traidings'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }

    public function deleteTraiding(int $traidingId)
    {
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";
        $response = $this->traidingRepository->deleteTraiding($traidingId);
        // $traiding = Traiding::find($request->id);
        // if ($traiding == null) {
        //     $title = "Error";
        //     $mensaje = "Hubo un error con el traiding";
        //     $status = "error";
        // }
        // try {
        //     if ($traiding->delete()) {
        //         $title = "Correcto";
        //         $mensaje = "El traiding se elimninó correctamente";
        //         $status = "success";
        //     } else {
        //         $title = "Error";
        //         $mensaje = "No se pudo eliminar el traiding";
        //         $status = "error";
        //     }
        // } catch (Exception $e) {
        //     $title = "Error";
        //     $mensaje = $e->getMessage();
        //     $status = "error";
        // }

        $traidings = $this->traidingRepository->getTraidings();

        // return response()->json(["view"=>view('traiding.table.tableTraiding', compact('traidings'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }
}