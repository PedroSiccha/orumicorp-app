<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CustomerStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CustomerStatusController extends Controller
{

    public function index() {
        return CustomerStatus::get();
    }

    public function saveCustomerStatus(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {

            $customerStatus = new CustomerStatus();
            $customerStatus->name = $request->name;
            $customerStatus->color = 'table-default';
            if ($customerStatus->save()) {
                $title = "Correcto";
                $mensaje = "El estado se registró correctamente";
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

        $customersStatus = CustomerStatus::get();

        return response()->json(["view"=>view('customerStatus.table.tableCustomerStatus', compact('customersStatus'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function updateCustomerStatus(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {
            // dd($request);
            $customerStatus = CustomerStatus::find($request->id);
            $customerStatus->name = $request->name;
            $customerStatus->color = 'table-default';

            if ($customerStatus->save()) {
                $title = "Correcto";
                $mensaje = "Se actualizó su estado correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "Hubo un error al actualizar su estado";
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

        $customersStatus = CustomerStatus::get();

        return response()->json(["view"=>view('customerStatus.table.tableCustomerStatus', compact('customersStatus'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function deleteCustomerStatus(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $customerStatus = CustomerStatus::find($request->id);
        if ($customerStatus == null) {
            $title = "Error";
            $mensaje = "Hubo un error con su estado";
            $status = "error";
        }
        try {
            if ($customerStatus->delete()) {
                $title = "Correcto";
                $mensaje = "Su estado se eliminó correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "No se pudo eliminar su estado";
                $status = "error";
            }
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        $customersStatus = CustomerStatus::get();

        return response()->json(["view"=>view('customerStatus.table.tableCustomerStatus', compact('customersStatus'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

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
