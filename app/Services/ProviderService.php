<?php
namespace App\Services;

use App\Http\Requests\ProviderRequest;
use App\Interfaces\ProviderInterface;
use App\Interfaces\ProviderRepositoryInterface;
use App\Models\Provider;
use Exception;

class ProviderService implements ProviderInterface {

    protected $providerRepository;

    public function __construct(
        ProviderRepositoryInterface $providerRepository
    ) {
        $this->providerRepository = $providerRepository;
    }

    public function getAllProvidersByCustomer($request) {
        try {
            $customerId = $request['customer_id'];
            $providers = Provider::whereHas('customers', function($query) use ($customerId) {
                $query->where('customer_id', $customerId);
            })->with('customers')->get();
            return response()->json([
                'status' => 'success',
                'data' => $providers,
            ]);
        } catch (Exception $e) {
            return collect();
        }
    }

    public function getLastProviderByCustomer($request) {
        try {
            $customerId = $request['customer_id'];
            $lastProvider = Provider::whereHas('customers', function($query) use ($customerId) {
                $query->where('customer_id', $customerId);
            })->with('customers')->orderBy('created_at', 'desc')->first();

            return response()->json([
                'status' => 'success',
                'data' => $lastProvider
            ]);
        } catch (Exception $e) {
            return null;
        }
    }

    public function saveProvider(ProviderRequest $request)
    {
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";

        // try {
        //     $role = Role::find(9);
        //     $user = new User();
        //     $user->name = $request->name;
        //     $user->email = $request->email;
        //     $user->password = Hash::make($request->phone);
        //     if ($user->save()) {
        //         $user->assignRole($role);
        //         $provider = new Provider();
        //         $provider->name = $request->name;
        //         $provider->phone = $request->phone;
        //         $provider->email = $request->email;
        //         $provider->user_id = $user->id;
        //         if ($provider->save()) {
        //             $title = "Correcto";
        //             $mensaje = "El proveedor se registró correctamente";
        //             $status = "success";
        //         }
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

        // $suppliers = Provider::get();

        // return response()->json(["view"=>view('provider.table.tableProvider', compact('suppliers'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }

    public function updateProvider(ProviderRequest $request)
    {
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";

        // try {

        //     $provider = Provider::find($request->id);
        //     $provider->name = $request->name;
        //     $provider->phone = $request->phone;
        //     $provider->email = $request->email;

        //     if ($provider->save()) {
        //         $title = "Correcto";
        //         $mensaje = "Se actualizó su proveedor correctamente";
        //         $status = "success";
        //     } else {
        //         $title = "Error";
        //         $mensaje = "Hubo un error al actualizar su proveedor";
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

        // $suppliers = Provider::get();

        // return response()->json(["view"=>view('provider.table.tableProvider', compact('suppliers'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }

    public function deleteProvider(ProviderRequest $request)
    {
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";
        // $provider = Provider::find($request->id);
        // if ($provider == null) {
        //     $title = "Error";
        //     $mensaje = "Hubo un error con su proveedor";
        //     $status = "error";
        // }
        // try {
        //     if ($provider->delete()) {
        //         $title = "Correcto";
        //         $mensaje = "Su proveedor se eliminó correctamente";
        //         $status = "success";
        //     } else {
        //         $title = "Error";
        //         $mensaje = "No se pudo eliminar su proveedor";
        //         $status = "error";
        //     }
        // } catch (Exception $e) {
        //     $title = "Error";
        //     $mensaje = $e->getMessage();
        //     $status = "error";
        // }

        // $suppliers = Provider::get();

        // return response()->json(["view"=>view('provider.table.tableProvider', compact('suppliers'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }

}
