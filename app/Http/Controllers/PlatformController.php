<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PlatformController extends Controller
{

    public function savePlatform(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {

            $platform = new Platform();
            $platform->name = $request->name;
            $platform->description = $request->description;
            $platform->status = 'active';
            if ($platform->save()) {
                $title = "Correcto";
                $mensaje = "Su platform se registró correctamente";
                $status = "success";
            }

        } catch (ValidationException $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        $platforms = Platform::get();

        return response()->json(["view"=>view('platform.table.tablePlatform', compact('platforms'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function updatePlatform(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {

            $platform = Platform::find($request->id);
            $platform->name = $request->name;
            $platform->description = $request->description;

            if ($platform->save()) {
                $title = "Correcto";
                $mensaje = "Se actualizó su platform correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "Hubo un error al actualizar su platform";
                $status = "error";
            }

        } catch (ValidationException $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = "Verificar los datos del registro";
            $status = "error";
        }

        $platforms = Platform::get();

        return response()->json(["view"=>view('platform.table.tablePlatform', compact('platforms'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function deletePlatform(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $platform = Platform::find($request->id);
        if ($platform == null) {
            $title = "Error";
            $mensaje = "Hubo un error con su platform";
            $status = "error";
        }
        try {
            if ($platform->delete()) {
                $title = "Correcto";
                $mensaje = "Su platform se eliminó correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "No se pudo eliminar su platform";
                $status = "error";
            }
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        $platforms = Platform::get();

        return response()->json(["view"=>view('platform.table.tablePlatform', compact('platforms'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Platform  $platform
     * @return \Illuminate\Http\Response
     */
    public function show(Platform $platform)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Platform  $platform
     * @return \Illuminate\Http\Response
     */
    public function edit(Platform $platform)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Platform  $platform
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Platform $platform)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Platform  $platform
     * @return \Illuminate\Http\Response
     */
    public function destroy(Platform $platform)
    {
        //
    }
}
