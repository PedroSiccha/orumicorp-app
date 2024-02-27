<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Customers;
use App\Models\Premio;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;

        $agent = Agent::where('user_id', $user_id)->first();
        $client = Customers::where('user_id', $user_id)->first();

        $dataUser = null;

        if ($agent) {
            $dataUser = $agent;
        }

        if ($client) {
            $dataUser = $client;
        }

        $customers = Customers::where('status', true)->orderBy('date_admission')->paginate(10);
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $roles = Role::get();
        return view('cliente.index', compact('customers', 'premios1', 'premios2', 'roles', 'dataUser'));
    }

    public function saveCustomer(Request $request)
    {
        $resp = 0;
        $role = Role::find($request->rol_id);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->dni);
        if ($user->save()) {
            $user->assignRole($role);
            $client = new Customers();
            $client->code = $request->code;
            $client->name = $request->name;
            $client->lastname = $request->lastname;
            $client->dni = $request->dni;
            $client->date_admission = Carbon::now();
            $client->status = true;
            $client->user_id = $user->id;
            if ($client->save()) {
                $resp = 1;
            }
        }

        $customers = Customers::where('status', true)->orderBy('date_admission')->paginate(10);

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "resp"=>$resp]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function asignAgent(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeStatusClient(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        $idClient = $request->id;
        $client = Customers::find($idClient);
        if ($client == null) {
            $title = "Error";
            $mensaje = "Hubo un error con el cliente";
            $status = "error";
        }
        $client->status = false;
        if ($client->save()) {
            $title = "Correcto";
            $mensaje = "Se cambió el estado del cliente";
            $status = "success";
        } else {
            $title = "Error";
            $mensaje = "No se pudo cambiar el estado del cliente";
            $status = "error";
        }
        $customers = Customers::where('status', true)->orderBy('date_admission')->paginate(10);

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateClient(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        $client = Customers::find($request->id);
        if ($client == null) {
            $title = "Error";
            $mensaje = "Hubo un error con el cliente";
            $status = "error";
        }
        $client->code = $request->code;
        $client->name = $request->name;
        $client->lastname = $request->lastname;
        $client->dni = $request->phone;

        $user = User::find($client->user_id);
        $user->name = $request->name;

        if ($client->save()) {
            if ($user->save()) {
                $title = "Correcto";
                $mensaje = "Se actualizó el cliente correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "Hubo un error al actualizar el usuario del cliente";
                $status = "error";
            }
        } else {
            $title = "Error";
            $mensaje = "Hubo un error al actualizar el cliente";
            $status = "error";
        }

        $customers = Customers::where('status', true)->orderBy('date_admission')->paginate(10);

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteClient(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $client = Customers::find($request->id);
        if ($client == null) {
            $title = "Error";
            $mensaje = "Hubo un error con el cliente";
            $status = "error";
        }
        if ($client->delete()) {
            $title = "Correcto";
            $mensaje = "El cliente se elimninó correctamente";
            $status = "success";
        } else {
            $title = "Error";
            $mensaje = "No se pudo eliminar el cliente";
            $status = "error";
        }

        $customers = Customers::where('status', true)->orderBy('date_admission')->paginate(10);

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

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
