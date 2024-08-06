<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Campaing;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CampaingController extends Controller
{

    public function saveCampaign(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {

            $campaign = new Campaing();
            $campaign->name = $request->name;
            $campaign->description = $request->description;
            $campaign->start_date = $request->startDate;
            $campaign->end_date = $request->endDate;
            if ($campaign->save()) {
                $title = "Correcto";
                $mensaje = "Su campaña se registró correctamente";
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

        $campaigns = Campaing::get();

        return response()->json(["view"=>view('campaign.table.tableCampaign', compact('campaigns'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }

    public function updateCampaign(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {

            $campaign = Campaing::find($request->id);
            $campaign->name = $request->name;
            $campaign->description = $request->description;
            $campaign->start_date = $request->startDate;
            $campaign->end_date = $request->endDate;

            if ($campaign->save()) {
                $title = "Correcto";
                $mensaje = "Se actualizó su campaña correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "Hubo un error al actualizar su campaña";
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

        $campaigns = Campaing::get();

        return response()->json(["view"=>view('campaign.table.tableCampaign', compact('campaigns'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function deleteCampaign(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $campaign = Campaing::find($request->id);
        if ($campaign == null) {
            $title = "Error";
            $mensaje = "Hubo un error con su campaña";
            $status = "error";
        }
        try {
            if ($campaign->delete()) {
                $title = "Correcto";
                $mensaje = "Su campaña se eliminó correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "No se pudo eliminar su campaña";
                $status = "error";
            }
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        $campaigns = Campaing::get();

        return response()->json(["view"=>view('campaign.table.tableCampaign', compact('campaigns'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
