<?php
namespace App\Services;

use App\Http\Requests\PlatformRequest;
use App\Interfaces\PlatformRepositoryInterface;
use Exception;
use Illuminate\Validation\ValidationException;

class PlatformService
{

    protected $platformRepository;

    public function __construct(
        PlatformRepositoryInterface $platformRepository
    ) {
        $this->platformRepository = $platformRepository;
    }

    public function savePlatform(StorePlatformRequest $request)
    {
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";

        try {
            $platform = $this->platformRepository->savePlatform($request);

        //     $platform = new Platform();
        //     $platform->name = $request->name;
        //     $platform->description = $request->description;
        //     $platform->status = 'active';
        //     if ($platform->save()) {
        //         $title = "Correcto";
        //         $mensaje = "Su platform se registró correctamente";
        //         $status = "success";
        //     }

        } catch (ValidationException $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        $platforms = $this->platformRepository->getPlatforms();

        // return response()->json(["view"=>view('platform.table.tablePlatform', compact('platforms'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }

    public function updatePlatform(EditPlatformRequest $request)
    {
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";

        try {
            $response = $this->platformRepository->updatePlatform($request);

        //     $platform = Platform::find($request->id);
        //     $platform->name = $request->name;
        //     $platform->description = $request->description;

        //     if ($platform->save()) {
        //         $title = "Correcto";
        //         $mensaje = "Se actualizó su platform correctamente";
        //         $status = "success";
        //     } else {
        //         $title = "Error";
        //         $mensaje = "Hubo un error al actualizar su platform";
        //         $status = "error";
        //     }

        } catch (ValidationException $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = "Verificar los datos del registro";
            $status = "error";
        }

        $platforms = $this->platformRepository->getPlatforms();

        // return response()->json(["view"=>view('platform.table.tablePlatform', compact('platforms'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }

    public function deletePlatform(int $platformId)
    {
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";
        // $platform = Platform::find($request->id);
        // if ($platform == null) {
        //     $title = "Error";
        //     $mensaje = "Hubo un error con su platform";
        //     $status = "error";
        // }
        try {
            $response = $this->platformRepository->deletePlatform($platformId);
        //     if ($platform->delete()) {
        //         $title = "Correcto";
        //         $mensaje = "Su platform se eliminó correctamente";
        //         $status = "success";
        //     } else {
        //         $title = "Error";
        //         $mensaje = "No se pudo eliminar su platform";
        //         $status = "error";
        //     }
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        $platforms = $platforms = $this->platformRepository->getPlatforms();

        // return response()->json(["view"=>view('platform.table.tablePlatform', compact('platforms'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }
}