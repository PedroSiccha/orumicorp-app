<?php
namespace App\Services;

use App\Interfaces\AssignamentInterface;
use App\Interfaces\CampaingInterface;
use App\Interfaces\ClientInterface;
use App\Interfaces\ComunicationInterface;
use App\Interfaces\ProviderInterface;
use App\Interfaces\RolesInterface;
use App\Interfaces\UserInterface;
use App\Models\Agent;
use App\Models\Assignment;
use App\Models\Campaing;
use App\Models\Configuration;
use App\Models\Customers;
use App\Models\CustomerStatus;
use App\Models\CustomerSummary;
use App\Models\Folder;
use App\Models\Platform;
use App\Models\Premio;
use App\Models\Priority;
use App\Models\Provider;
use App\Models\Task;
use App\Models\Traiding;
use App\Models\User;
use App\Models\Views;
use App\Rules\PhoneNumberFormat;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ClientService implements ClientInterface {
    protected $userService;
    protected $rolesService;
    protected $awardsService;
    protected $communicationService;
    protected $assignamentService;
    protected $campaingService;
    protected $providerService;
    protected $utils;

    public function __construct(
        UserInterface $userService,
        RolesInterface $rolesService,
        AwardsService $awardsService,
        ComunicationInterface $communicationService,
        AssignamentInterface $assignamentService,
        CampaingInterface $campaingService,
        ProviderInterface $providerService,
        Utils $utils,
    ) {
        $this->userService = $userService;
        $this->rolesService = $rolesService;
        $this->awardsService = $awardsService;
        $this->communicationService = $communicationService;
        $this->assignamentService = $assignamentService;
        $this->campaingService = $campaingService;
        $this->providerService = $providerService;
        $this->utils = $utils;
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

        if ($myRoles['roles'] == 'ADMINISTRADOR') {
            $customers = Customers::with([
                'user',
                'agent',
                'latestCampaign',
                'latestSupplier',
                'provider',
                'statusCustomer',
                'platform',
                'traiding',
                'latestComunication',
                'latestAssignamet',
                'latestDeposit',
                'folder'
            ])->orderBy('date_admission', 'desc')->paginate(10);

            // dd($customers);

        } else {

            $customers = Customers::with([
                'user',
                'agent',
                'latestCampaign',
                'latestSupplier',
                'provider',
                'statusCustomer',
                'platform',
                'traiding',
                'assignaments',
                'latestComunication',
                'latestAssignamet',
                'latestDeposit',
                'folder'
            ])->whereHas('assignaments', function($query) use ($agent) {
                $query->where('agent_id', $agent->id);
            })->orderBy('date_admission', 'desc')->paginate(10);


            // dd($customers);
        }

        $asignCustomers = Customers::where('agent_id', null)->where('status', 1)->orderBy('date_admission')->get();

        $premios = $this->awardsService->chargeAwards();
        $premios1 = $premios['premios1'];
        $premios2 = $premios['premios2'];
        $roles = Role::get();

        $configTablesDateInit = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'date_init')
                                     ->first();

        if ($configTablesDateInit == null) {
            $configTablesDateInit = new Configuration();
            $configTablesDateInit->user_id = $user_id;
            $configTablesDateInit->name = 'date_init';
            $configTablesDateInit->view = 'tabClient';
            $configTablesDateInit->status = 'active';
            $configTablesDateInit->save();

        }

        $configTablesCode = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'code')
                                     ->first();

        if ($configTablesCode === null) {
            $configTablesCode = new Configuration();
            $configTablesCode->user_id = $user_id;
            $configTablesCode->name = 'code';
            $configTablesCode->view = 'tabClient';
            $configTablesCode->status = 'active';
            $configTablesCode->save();
        }

        $configTablesPhone = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'phone')
                                     ->first();

        if ($configTablesPhone === null) {
            $configTablesPhone = new Configuration();
            $configTablesPhone->user_id = $user_id;
            $configTablesPhone->name = 'phone';
            $configTablesPhone->view = 'tabClient';
            $configTablesPhone->status = 'active';
            $configTablesPhone->save();
        }

        $configTablesOptionalPhone = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'optional_phone')
                                     ->first();

        if ($configTablesOptionalPhone === null) {
            $configTablesOptionalPhone = new Configuration();
            $configTablesOptionalPhone->user_id = $user_id;
            $configTablesOptionalPhone->name = 'optional_phone';
            $configTablesOptionalPhone->view = 'tabClient';
            $configTablesOptionalPhone->status = 'active';
            $configTablesOptionalPhone->save();
        }

        $configTablesEmail = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'email')
                                     ->first();

        if ($configTablesEmail === null) {
            $configTablesEmail = new Configuration();
            $configTablesEmail->user_id = $user_id;
            $configTablesEmail->name = 'email';
            $configTablesEmail->view = 'tabClient';
            $configTablesEmail->status = 'active';
            $configTablesEmail->save();
        }

        $configTablesCity = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'city')
                                     ->first();

        if ($configTablesCity === null) {
            $configTablesCity = new Configuration();
            $configTablesCity->user_id = $user_id;
            $configTablesCity->name = 'city';
            $configTablesCity->view = 'tabClient';
            $configTablesCity->status = 'active';
            $configTablesCity->save();
        }

        $configTablesCountry = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'country')
                                     ->first();

        if ($configTablesCountry === null) {
            $configTablesCountry = new Configuration();
            $configTablesCountry->user_id = $user_id;
            $configTablesCountry->name = 'country';
            $configTablesCountry->view = 'tabClient';
            $configTablesCountry->status = 'active';
            $configTablesCountry->save();
        }

        $configTablesComment = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'comment')
                                     ->first();

        if ($configTablesComment === null) {
            $configTablesComment = new Configuration();
            $configTablesComment->user_id = $user_id;
            $configTablesComment->name = 'comment';
            $configTablesComment->view = 'tabClient';
            $configTablesComment->status = 'active';
            $configTablesComment->save();
        }

        $providers = Provider::all();
        $platforms = Platform::all();
        $traidings = Traiding::all();
        $statusCustomers = CustomerStatus::all();
        $folders = Folder::where('status', true)->get();
        $agents = Agent::all();
        $campaings = Campaing::all();

        return compact('customers', 'premios1', 'premios2', 'roles', 'dataUser', 'rouletteSpin', 'asignCustomers', 'myRolesId', 'configTablesDateInit', 'configTablesCode', 'configTablesPhone', 'configTablesOptionalPhone', 'configTablesEmail', 'configTablesCity', 'configTablesCountry', 'configTablesComment', 'providers', 'platforms', 'traidings', 'statusCustomers', 'folders', 'agents', 'campaings');
    }

    public function saveClient($request) {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:customers,email',
                'phone' => 'required|string|unique:customers,phone',
                'name'  => 'required|string',
                'lastname' => 'required|string',
            ], [
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.unique' => 'El correo electrónico ya está registrado.',
                'phone.required' => 'El número de teléfono es obligatorio.',
                'phone.unique' => 'El número de teléfono ya está registrado.',
                'name.required' => 'El nombre es obligatorio.',
                'lastname.required' => 'El apellido es obligatorio.',
            ]);

            if ($validator->fails()) {
                $errorMessages = implode(' ', $validator->errors()->all());
                return [
                    'title' => 'Error',
                    'mensaje' => $errorMessages,
                    'status' => 'error'
                ];
            }

            $role = Role::where('name', 'CLIENTE')->first();
            $statusClient = CustomerStatus::where('name', 'NUEVO')->first();

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->dni);

            if ($user->save()) {
                $user->assignRole($role->id);

                $code = $this->utils->getInitials($request->name) . $this->utils->getInitials($request->lastname) . '_' . $user->id;

                $client = new Customers();
                $client->code = $code;
                $client->name = $request->name;
                $client->lastname = $request->lastname;
                $client->phone = $request->phone;
                $client->email = $request->email;
                $client->date_admission = now();
                $client->status = true;
                $client->user_id = $user->id;
                $client->id_status = $statusClient->id;

                if ($client->save()) {
                    return [
                        'title' => 'Correcto',
                        'mensaje' => 'El cliente se registró correctamente.',
                        'status' => 'success'
                    ];
                }
            }
        } catch (Exception $e) {
            return [
                'title' => 'Error',
                'mensaje' => 'Error inesperado',
                'status' => 'error'
            ];
        }
    }

    public function asignAgent($request) {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        $agent = Agent::where('code_voiso', $request->dni_agent)
                        ->orWhere('code', $request->dni_agent)
                        ->first();

        $user_id = Auth::user()->id;

        try {

            $oldAssignments = Assignment::where('customer_id', $request->id)
                                        ->where('status', 1)
                                        ->get();
            foreach ($oldAssignments as $oldAssign) {
                $oldAssign->status = 0;
                $oldAssign->save();
            }

            $assignament = new Assignment();
            $assignament->agent_id = $agent->id;
            $assignament->customer_id = $request->id;
            $assignament->date = Carbon::now();
            $assignament->assignated_by_id = $user_id;
            $assignament->status = 1;
            $assignament->save();
            // dd($assignament);

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

    public function assignGroupAgent($request) {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        $agent = Agent::where('code_voiso', $request->dni_agent)
                        ->orWhere('code', $request->dni_agent)
                        ->first();

        $user_id = Auth::user()->id;

        try {
            foreach ($request->idGroupClientes as $idClient) {

                $oldAssignments = Assignment::where('customer_id', $idClient)
                                        ->where('status', 1)
                                        ->get();


                foreach ($oldAssignments as $oldAssign) {
                    $oldAssign->status = 0;
                    $oldAssign->save();
                }

                $assignament = new Assignment();
                $assignament->agent_id = $agent->id;
                $assignament->customer_id = $idClient;
                $assignament->date = Carbon::now();
                $assignament->assignated_by_id = $user_id;
                $assignament->status = 1;
                $assignament->save();

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
        $dataCommunication = [
            'customer_id' => $dataCustomer->id,
            // 'customerStatusId' => $dataCustomer->customerStatusId
        ];

        $communications = $this->communicationService->getLocationByCustomer($dataCommunication);
        $lastAssignament = $this->assignamentService->getLastAssignamentByCustomer($dataCommunication);
        $lastCampaing = $this->campaingService->getLastCampaingByCustomer($dataCommunication);
        // dd($lastCampaing);
        $campaings = $this->campaingService->getAllCampaingsByCustomer($dataCommunication);
        // dd($campaings['name']);
        $lastProvider = $this->providerService->getLastProviderByCustomer($dataCommunication);
        $providers = $this->providerService->getAllProvidersByCustomer($dataCommunication);
        $priorities = Priority::all();
        $eventos = Task::with('customer')->where('customer_id', $id)->get();

        $vistas = Views::with('agent')
                        ->where('customer_id', $dataCustomer->id)
                        ->get();

        return compact('rouletteSpin', 'dataUser', 'premios1', 'premios2', 'dataCustomer', 'communications', 'lastAssignament', 'lastCampaing', 'campaings', 'lastProvider', 'providers', 'priorities', 'eventos', 'vistas');

    }

}
