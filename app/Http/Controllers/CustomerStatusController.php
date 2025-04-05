<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CustomerStatus;
use App\Services\CustomerStatusService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CustomerStatusController extends Controller
{

    protected $customerStatusService;

    public function __construct(CustomerStatusService $customerStatusService) {
        $this->customerStatusService = $customerStatusService;
    }

    public function index() {
        return CustomerStatus::get();
    }

    public function saveCustomerStatus(CustomerStatusRequest $request)
    {
        try {
            $data = $this->customerStatusService->saveCustomerStatus($request);
            $customersStatus = $data->customersStatus;
            return response()->json(["view"=>view('customerStatus.table.tableCustomerStatus', compact('customersStatus'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en CustomerStatusController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar los estados de cliente.');
        }
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";

        // try {

        //     $customerStatus = new CustomerStatus();
        //     $customerStatus->name = $request->name;
        //     $customerStatus->color = 'table-default';
        //     if ($customerStatus->save()) {
        //         $title = "Correcto";
        //         $mensaje = "El estado se registró correctamente";
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

        // $customersStatus = CustomerStatus::get();

        // return response()->json(["view"=>view('customerStatus.table.tableCustomerStatus', compact('customersStatus'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function updateCustomerStatus(CustomerStatusRequest $request)
    {
        try {
            $data = $this->customerStatusService->updateCustomerStatus($request);
            $customersStatus = $data->customersStatus;
            return response()->json(["view"=>view('customerStatus.table.tableCustomerStatus', compact('customersStatus'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en CustomerStatusController: " . $e->getMessage());
        }
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";

        // try {

        //     $customerStatus = CustomerStatus::find($request->id);
        //     $customerStatus->name = $request->name;
        //     $customerStatus->color = 'table-default';

        //     if ($customerStatus->save()) {
        //         $title = "Correcto";
        //         $mensaje = "Se actualizó su estado correctamente";
        //         $status = "success";
        //     } else {
        //         $title = "Error";
        //         $mensaje = "Hubo un error al actualizar su estado";
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

        // $customersStatus = CustomerStatus::get();

        // return response()->json(["view"=>view('customerStatus.table.tableCustomerStatus', compact('customersStatus'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function deleteCustomerStatus(CustomerStatusRequest $request)
    {
        try {
            $data = $this->customerStatusService->deleteCustomerStatus($request);
            $customersStatus = $data->customersStatus;
            return response()->json(["view"=>view('customerStatus.table.tableCustomerStatus', compact('customersStatus'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en CustomerStatusController: " . $e->getMessage());
        }
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";
        // $customerStatus = CustomerStatus::find($request->id);
        // if ($customerStatus == null) {
        //     $title = "Error";
        //     $mensaje = "Hubo un error con su estado";
        //     $status = "error";
        // }
        // try {
        //     if ($customerStatus->delete()) {
        //         $title = "Correcto";
        //         $mensaje = "Su estado se eliminó correctamente";
        //         $status = "success";
        //     } else {
        //         $title = "Error";
        //         $mensaje = "No se pudo eliminar su estado";
        //         $status = "error";
        //     }
        // } catch (Exception $e) {
        //     $title = "Error";
        //     $mensaje = $e->getMessage();
        //     $status = "error";
        // }

        // $customersStatus = CustomerStatus::get();

        // return response()->json(["view"=>view('customerStatus.table.tableCustomerStatus', compact('customersStatus'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

}
