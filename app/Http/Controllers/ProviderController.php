<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class ProviderController extends Controller
{

    public function saveProvider(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {
            $role = Role::find(9);
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->phone);
            if ($user->save()) {
                $user->assignRole($role);
                $provider = new Provider();
                $provider->name = $request->name;
                $provider->phone = $request->phone;
                $provider->email = $request->email;
                $provider->user_id = $user->id;
                if ($provider->save()) {
                    $title = "Correcto";
                    $mensaje = "El proveedor se registró correctamente";
                    $status = "success";
                }
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

        $suppliers = Provider::get();

        return response()->json(["view"=>view('provider.table.tableProvider', compact('suppliers'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function updateProvider(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {

            $provider = Provider::find($request->id);
            $provider->name = $request->name;
            $provider->phone = $request->phone;
            $provider->email = $request->email;

            if ($provider->save()) {
                $title = "Correcto";
                $mensaje = "Se actualizó su proveedor correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "Hubo un error al actualizar su proveedor";
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

        $suppliers = Provider::get();

        return response()->json(["view"=>view('provider.table.tableProvider', compact('suppliers'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function deleteProvider(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $provider = Provider::find($request->id);
        if ($provider == null) {
            $title = "Error";
            $mensaje = "Hubo un error con su proveedor";
            $status = "error";
        }
        try {
            if ($provider->delete()) {
                $title = "Correcto";
                $mensaje = "Su proveedor se eliminó correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "No se pudo eliminar su proveedor";
                $status = "error";
            }
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        $suppliers = Provider::get();

        return response()->json(["view"=>view('provider.table.tableProvider', compact('suppliers'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

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
