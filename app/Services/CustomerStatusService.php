<?php
namespace App\Services;

use App\Interfaces\ClientStatusRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CustomerStatusService
{
    protected $customerStatusRepository;

    public function __construct(
        ClientStatusRepositoryInterface $customerStatusRepository
    ) {
        $this->customerStatusRepository = $customerStatusRepository;
    }

    public function getCustomerStatus() {
        $customerStatus = $this->customerStatusRepository->getCustomerStatus();
    }

    public function saveCustomerStatus($request)
    {
        DB::beginTransaction();
        try {
            $customerStatus = $this->customerStatusRepository->saveCustomerStatus($request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["resp"=>0]);
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

        $customerStatus = $this->customerStatusRepository->getCustomerStatus();
    }

    public function updateCustomerStatus($request)
    {
        DB::beginTransaction();
        try {
            $customerStatus = $this->customerStatusRepository->updateCustomerStatus($request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["resp"=>0]);
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

        $customerStatus = $this->customerStatusRepository->getCustomerStatus();
    }

    public function deleteCustomerStatus($request)
    {
        DB::beginTransaction();
        try {
            $customerStatus = $this->customerStatusRepository->deleteCustomerStatus($request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["resp"=>0]);
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
        $customerStatus = $this->customerStatusRepository->getCustomerStatus();
    }
}