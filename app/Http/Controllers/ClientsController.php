<?php

namespace App\Http\Controllers;

use App\Imports\CustomersImport;
use App\Imports\UsersImport;
use App\Models\Agent;
use App\Models\Customers;
use App\Models\Premio;
use App\Models\User;
use App\Rules\PhoneNumberFormat;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Webpatser\Countries\Countries;

class ClientsController extends Controller
{

    public function index()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        $roles = $user->getRoleNames()->first();

        $agent = Agent::where('user_id', $user_id)->first();
        $client = Customers::where('user_id', $user_id)->first();
        $rouletteSpin = $agent->number_turns ?: 0;

        $dataUser = null;

        if ($agent) {
            $dataUser = $agent;
        }

        if ($client) {
            $dataUser = $client;
        }

        if ($roles == 'ADMINISTRADOR') {
            $customers = Customers::orderBy('date_admission')->paginate(10);
        } else {
            $customers = Customers::where('agent_id', $agent->id)->orderBy('date_admission')->paginate(10);
        }

        $asignCustomers = Customers::where('agent_id', null)->where('status', 1)->orderBy('date_admission')->get();

        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $roles = Role::get();
        return view('cliente.index', compact('customers', 'premios1', 'premios2', 'roles', 'dataUser', 'rouletteSpin', 'asignCustomers'));
    }

    public function saveCustomer(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {
            $resp = 0;
            $role = Role::find($request->rol_id);

            $request->validate([
                'phone' => ['required', new PhoneNumberFormat],
                'optionalPhone' => ['nullable', 'sometimes', new PhoneNumberFormat],
            ]);

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
                $client->phone = $request->phone;
                $client->optional_phone = $request->optionalPhone;
                $client->city = $request->city;
                $client->country = $request->country;
                $client->date_admission = Carbon::now();
                $client->status = true;
                $client->user_id = $user->id;
                $client->comment = $request->comment;
                $client->email = $request->email;
                if ($client->save()) {
                    $resp = 1;
                }
            }

            $title = "Correcto";
            $mensaje = "El cliente se registró correctamente";
            $status = "success";

        } catch (ValidationException $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = "Verifique los datos registrados";
            $status = "error";
        }

        $customers = Customers::orderBy('date_admission')->paginate(10);

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }

    public function asignAgent(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        $agent = Agent::where('dni', $request->dni_agent)
                  ->orWhere('code', $request->dni_agent)
                  ->first();

        $client = Customers::find($request->id);
        $client->agent_id = $agent->id;
        if ($client->save()) {
            $title = "Correcto";
            $mensaje = "Se asignó correctamente el agente";
            $status = "success";
        } else {
            $title = "Error";
            $mensaje = "Error desconocido";
            $status = "error";
        }
        $customers = Customers::orderBy('date_admission')->paginate(10);

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function assignGroupAgent(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        $agent = Agent::where('dni', $request->dni_agent)
                  ->orWhere('code', $request->dni_agent)
                  ->first();

        try {
            foreach ($request->idGroupClientes as $idClient) {
                $client = Customers::find($idClient);
                $client->agent_id = $agent->id;
                $client->save();
            }

            $title = "Correcto";
            $mensaje = "Se asignó correctamente el agente";
            $status = "success";

        } catch (Exception $e) {
            $title = "Error";
            $mensaje = "Ocurrió un error: " . $e->getMessage();
            $status = "error";
        }

        $customers = Customers::orderBy('date_admission')->paginate(10);

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

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
        $client->status = $request->status;
        if ($client->save()) {
            $title = "Correcto";
            $mensaje = "Se cambió el estado del cliente";
            $status = "success";
        } else {
            $title = "Error";
            $mensaje = "No se pudo cambiar el estado del cliente";
            $status = "error";
        }
        $customers = Customers::orderBy('date_admission')->paginate(10);

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function updateClient(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {

            $client = Customers::find($request->id);
            $client->code = $request->code;
            $client->name = $request->name;
            $client->lastname = $request->lastname;
            $client->phone = $request->phone;
            $client->optional_phone = $request->optionalPhone;
            $client->city = $request->city;
            $client->country = $request->country;
            $client->comment = $request->comment;
            $client->email = $request->email;

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

        } catch (ValidationException $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = "Verificar los datos del registro";
            $status = "error";
        }

        $customers = Customers::orderBy('date_admission')->paginate(10);

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }

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

        $customers = Customers::orderBy('date_admission')->paginate(10);

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function descargarArchivo()
    {
        $archivo = public_path('utils/CARGA_MASIVA_DE_CLNT.xlsx');

        return Response::download($archivo, 'CARGA_MASIVA_DE_CLNT.xlsx');
    }

    public function uploadExcel(Request $request)
    {
        $file = $request->file;

        // Importar los usuarios
       // Excel::import(new UsersImport, $file);

        // Importar los clientes
        //Excel::import(new CustomersImport, $file);

        Excel::import(new CustomersImport, $file, null, \Maatwebsite\Excel\Excel::XLSX, [
            AfterImport::class => function (AfterImport $event) {
                $customers = Customers::orderBy('date_admission')->paginate(10);
                $title = "Correcto";
                $mensaje = "El cliente se eliminó correctamente";
                $status = "success";

                return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
            }
        ]);
    }
}
