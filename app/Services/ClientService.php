<?php
namespace App\Services;

use App\Interfaces\ClientInterface;
use App\Interfaces\RolesInterface;
use App\Interfaces\UserInterface;
use App\Models\Agent;
use App\Models\Customers;
use App\Models\Premio;
use App\Models\User;
use App\Rules\PhoneNumberFormat;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ClientService implements ClientInterface {
    protected $userService;
    protected $rolesService;
    protected $awardsService;

    public function __construct(
        UserInterface $userService,
        RolesInterface $rolesService,
        AwardsService $awardsService,
    ) {
        $this->userService = $userService;
        $this->rolesService = $rolesService;
        $this->awardsService = $awardsService;
    }

    public function index() {

        $myRoles = $this->rolesService->getMyRoles();
        $myRolesId = $myRoles['rolesId'];

        $user_id = Auth::user()->id;
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

        if ($myRoles['roles']== 'ADMINISTRADOR') {
            $customers = Customers::orderBy('date_admission')->get();
        } else {
            $customers = Customers::where('agent_id', $agent->id)->orderBy('date_admission')->get();
        }

        $asignCustomers = Customers::where('agent_id', null)->where('status', 1)->orderBy('date_admission')->get();

        $premios = $this->awardsService->chargeAwards();
        $premios1 = $premios['premios1'];
        $premios2 = $premios['premios2'];
        $roles = Role::get();
        $configTables = Permission::where('name', 'LIKE', '%- TabClient')->get();

        return compact('customers', 'premios1', 'premios2', 'roles', 'dataUser', 'rouletteSpin', 'asignCustomers', 'configTables', 'myRolesId');
    }

    public function saveClient($request) {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {

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
                    $title = "Correcto";
                    $mensaje = "El cliente se registró correctamente";
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

        return [
            'title' => $title,
            'mensaje' => $mensaje,
            'status' => $status
        ];

    }

    public function asignAgent($request) {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        $agent = Agent::where('dni', $request->dni_agent)
                  ->orWhere('code', $request->dni_agent)
                  ->first();

        $client = Customers::find($request->id);

        try {
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
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = "Ocurrió un error: " . $e->getMessage();
            $status = "error";
        }

        return [
            'title' => $title,
            'mensaje' => $mensaje,
            'status' => $status
        ];

    }

    public function assignGroupAgent($request) {
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

        return [
            'title' => $title,
            'mensaje' => $mensaje,
            'status' => $status
        ];
    }

    public function changeStatusClient($request) {

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
        try {
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
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = "Ocurrió un error: " . $e->getMessage();
            $status = "error";
        }

        return [
            'title' => $title,
            'mensaje' => $mensaje,
            'status' => $status
        ];
    }

    public function updateClient($request) {
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

        return [
            'title' => $title,
            'mensaje' => $mensaje,
            'status' => $status
        ];

    }

    public function deleteClient($request) {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $client = Customers::find($request->id);
        if ($client == null) {
            $title = "Error";
            $mensaje = "Hubo un error con el cliente";
            $status = "error";
        }
        try {
            if ($client->delete()) {
                $title = "Correcto";
                $mensaje = "El cliente se elimninó correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "No se pudo eliminar el cliente";
                $status = "error";
            }
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        return [
            'title' => $title,
            'mensaje' => $mensaje,
            'status' => $status
        ];
    }

    public function profileClient($id) {
        $myRoles = $this->rolesService->getMyRoles();

        $user_id = Auth::user()->id;
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

        $premios = $this->awardsService->chargeAwards();
        $premios1 = $premios['premios1'];
        $premios2 = $premios['premios2'];
        $dataCustomer = Customers::where('id', $id)->first();

        return compact('rouletteSpin', 'dataUser', 'premios1', 'premios2', 'dataCustomer');

    }

}