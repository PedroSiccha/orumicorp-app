<?php

namespace App\Http\Controllers;

use App\Models\Traiding;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TraidingController extends Controller
{

    public function saveTraiding(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {

            $trading = new Traiding();
            $trading->code = $request->code;
            $trading->description = $request->description;
            $trading->status = 'active';
            if ($trading->save()) {
                $title = "Correcto";
                $mensaje = "El trading se registró correctamente";
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

        $traidings = Traiding::get();

        return response()->json(["view"=>view('traiding.table.tableTraiding', compact('traidings'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function updateTraiding(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {

            $trading = Traiding::find($request->id);
            $trading->code = $request->code;
            $trading->description = $request->description;
            $trading->status = $request->status;

            if ($trading->save()) {
                $title = "Correcto";
                $mensaje = "Se actualizó su trading correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "Hubo un error al actualizar su trading";
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

        $traidings = Traiding::get();

        return response()->json(["view"=>view('traiding.table.tableTraiding', compact('traidings'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function deleteTraiding(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $traiding = Traiding::find($request->id);
        if ($traiding == null) {
            $title = "Error";
            $mensaje = "Hubo un error con el traiding";
            $status = "error";
        }
        try {
            if ($traiding->delete()) {
                $title = "Correcto";
                $mensaje = "El traiding se elimninó correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "No se pudo eliminar el traiding";
                $status = "error";
            }
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        $traidings = Traiding::get();

        return response()->json(["view"=>view('traiding.table.tableTraiding', compact('traidings'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Traiding  $traiding
     * @return \Illuminate\Http\Response
     */
    public function show(Traiding $traiding)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Traiding  $traiding
     * @return \Illuminate\Http\Response
     */
    public function edit(Traiding $traiding)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Traiding  $traiding
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Traiding $traiding)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Traiding  $traiding
     * @return \Illuminate\Http\Response
     */
    public function destroy(Traiding $traiding)
    {
        //
    }
}
