<?php

namespace App\Http\Controllers;

use App\Imports\CustomersImport;
use App\Imports\UsersImport;
use App\Interfaces\AssignamentInterface;
use App\Interfaces\ClientInterface;
use App\Interfaces\RolesInterface;
use App\Interfaces\UserInterface;
use App\Models\Agent;
use App\Models\Assignment;
use App\Models\Campaing;
use App\Models\Configuration;
use App\Models\Customers;
use App\Models\CustomerStatus;
use App\Models\Premio;
use App\Models\Priority;
use App\Models\Provider;
use App\Models\Task;
use App\Models\User;
use App\Rules\PhoneNumberFormat;
use App\Services\AgentService;
use App\Services\DateService;
use Carbon\Carbon as CarbonCarbon;
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
    protected $clientService, $userService, $rolesService, $agentService, $assignamentService, $dateService;

    public function __construct(
        ClientInterface $clientService,
        RolesInterface $rolesService,
        AgentService $agentService,
        AssignamentInterface $assignamentService,
        DateService $dateService
    ) {
        $this->clientService = $clientService;
        $this->rolesService = $rolesService;
        $this->agentService = $agentService;
        $this->assignamentService = $assignamentService;
        $this->dateService = $dateService;
    }

    public function index()
    {
        $data = $this->clientService->index();
        return view('cliente.index', $data);
    }

    public function clientsPagination(Request $request)
    {
        $myRoles = $this->rolesService->getMyRoles();
        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();

        $limit = $request->input('limit', 10);
        $filterFor = $request->input('filterFor', '');
        $inputName = $request->input('inputName', '');
        $statusId = $request->input('statusId', '');
        $typeRange = $request->input('typeRange', '');
        $dateInit = $request->input('dateInit', '');
        $dateEnd = $request->input('dateEnd', '');

        // 🔹 Convertir fechas al formato correcto
        if (!empty($dateInit)) {
            $dateInit = \Carbon\Carbon::createFromFormat('Y-m-d', $dateInit)->startOfDay();
        }
        if (!empty($dateEnd)) {
            $dateEnd = \Carbon\Carbon::createFromFormat('Y-m-d', $dateEnd)->endOfDay();
        }

        // 🔹 Iniciar la consulta con los datos
        $query = Customers::with([
            'user', 'agent', 'latestCampaign', 'latestSupplier', 'provider', 'statusCustomer',
            'platform', 'traiding', 'latestComunication', 'latestAssignamet', 'latestDeposit', 'folder'
        ]);

        // 🔹 Aplicar filtros solo si se han seleccionado
        if (!empty($inputName) && $filterFor !== 'Filtrar Por:') {
            $filterMap = [
                'Cod. Cliente'       => 'code',
                'Correo'             => 'email',
                'Teléfono'           => 'phone',
                'Teléfono Opcional'  => 'optional_phone',
                'Ciudad'             => 'city',
                'País'               => 'country',
                'Comentario'         => 'comment',
                'Folder'             => 'folder.name',
            ];

            if (isset($filterMap[$filterFor])) {
                $query->where($filterMap[$filterFor], 'like', "%$inputName%");
            }
        }

        // 🔹 Filtrar por estado si está seleccionado
        if (!empty($statusId) && $statusId !== "Seleccione un estado") {
            $query->where('id_status', $statusId);
        }

        // 🔹 Filtrar por rango de fechas si se seleccionó
        if (!empty($typeRange) && $typeRange !== "Seleccione Rango:" && !empty($dateInit) && !empty($dateEnd)) {
            $rangeMap = [
                "Última Llamada"            => 'comunications.date',
                "Fecha de Ingreso"          => 'date_admission',
                "Fecha de Última Llamada"   => 'comunications.date',
                "Fecha de Última Asignación"=> 'assignaments.date',
            ];

            if (isset($rangeMap[$typeRange]) && $dateInit <= $dateEnd) {
                $column = $rangeMap[$typeRange];

                if (strpos($column, '.') !== false) {
                    $relation = explode('.', $column)[0];
                    $field = explode('.', $column)[1];

                    $query->whereHas($relation, function ($q) use ($field, $dateInit, $dateEnd) {
                        $q->whereBetween($field, [$dateInit, $dateEnd]);
                    });
                } else {
                    $query->whereBetween($column, [$dateInit, $dateEnd]);
                }
            }
        }

        // 🔹 Filtrar clientes según el rol del usuario
        if ($myRoles['roles'] !== 'ADMINISTRADOR') {
            $query->whereHas('assignaments', function ($q) use ($agent) {
                $q->where('agent_id', $agent->id);
            });
        }

        // 🔹 Obtener resultados paginados
        $customers = $query->orderBy('date_admission', 'desc')->paginate($limit);

        return view('cliente.list.listCustomer', compact('customers'));
    }





    public function saveCustomer(Request $request)
    {
        $myRoles = $this->rolesService->getMyRoles();
        $myRolesId = $myRoles['rolesId'];
        $data = $this->clientService->saveClient($request);
        $agent = $this->agentService->getAgent();
        $customers = $this->getClients($myRoles['roles'], $agent);
        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();
        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(), "title"=>$data['title'], "text"=>$data['mensaje'], "status"=>$data['status']]);
    }

    public function getClients($roles, $agent)
    {
        if ($roles== 'ADMINISTRADOR') {
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
                'latestDeposit'
            ])->orderBy('date_admission', 'desc')->paginate(10);
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
                'latestDeposit'
            ])->whereHas('assignaments', function($query) use ($agent) {
                $query->where('agent_id', $agent->id);
            })->orderBy('date_admission', 'desc')->paginate(10);
        }
        return $customers;
    }

    public function asignAgent(Request $request)
    {
        $data = $this->clientService->asignAgent($request);
        $customers = Customers::orderBy('date_admission')->get();
        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "title"=>$data['title'], "text"=>$data['mensaje'], "status"=>$data['status']]);

    }

    public function assignGroupAgent(Request $request)
    {
        $data = $this->clientService->assignGroupAgent($request);
        $myRoles = $this->rolesService->getMyRoles();
        $agent = $this->agentService->getAgent();
        $customers = $this->getClients($myRoles['roles'], $agent);
        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();
        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(), "title"=>$data['title'], "text"=>$data['mensaje'], "status"=>$data['status']]);
    }

    public function asignAgentByProfile(Request $request)
    {
        $data = $this->clientService->asignAgent($request);
        $lastAssignament = $this->assignamentService->getLastAssignamentByCustomer($request);
        return response()->json(["view"=>view('cliente.components.assignedAgent', compact('lastAssignament'))->render(), "title"=>$data['title'], "text"=>$data['mensaje'], "status"=>$data['status']]);
    }

    public function changeStatusGroup(Request $request)
    {
        $title = 'Error';
        $mensaje = 'Error desconocido';
        $status = 'error';

        $myRoles = $this->rolesService->getMyRoles();
        $myRolesId = $myRoles['rolesId'];
        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();
        $limit = $request->input('limit', 10); // Por defecto muestra 10 registros

        try {
            foreach ($request->idGroupClientes as $idClient) {

                $client = Customers::find($idClient);
                $client->id_status = $request->statusId;
                $client->save();

            }

            $title = "Correcto";
            $mensaje = "Actualización correcta";
            $status = "success";

        } catch (Exception $e) {
            $title = "Error";
            $mensaje = "Ocurrió un error: " . $e->getMessage();
            $status = "error";
        }

        if ($myRoles['roles']== 'ADMINISTRADOR') {

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
                'latestDeposit'
            ])->orderBy('date_admission', 'desc')->paginate($limit);

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
                'latestDeposit'
            ])->whereHas('assignaments', function($query) use ($agent) {
                $query->where('agent_id', $agent->id);
            })->orderBy('date_admission', 'desc')->paginate($limit);
        }

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function searchStatus(Request $request) {
        $customerStatusId = $request->customerStatusId;

        $myRoles = $this->rolesService->getMyRoles();
        $myRolesId = $myRoles['rolesId'];
        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();
        $limit = $request->input('limit', 10); // Por defecto muestra 10 registros

        if ($myRoles['roles']== 'ADMINISTRADOR') {

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
                'latestDeposit'
            ])->where('id_status', $customerStatusId)->orderBy('date_admission', 'desc')->paginate($limit);

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
                'latestDeposit'
            ])->whereHas('assignaments', function($query) use ($agent) {
                $query->where('agent_id', $agent->id);
            })->where('id_status', $customerStatusId)->orderBy('date_admission', 'desc')->paginate($limit);

        }

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render()]);

    }

    public function changeStatusClient(Request $request)
    {
        $data = $this->clientService->changeStatusClient($request);
        $myRoles = $this->rolesService->getMyRoles();

        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();
        $limit = $request->input('limit', 10); // Por defecto muestra 10 registros

        if ($myRoles['roles']== 'ADMINISTRADOR') {

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
                'latestDeposit'
            ])->orderBy('date_admission', 'desc')->paginate($limit);

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
                'latestDeposit'
            ])->whereHas('assignaments', function($query) use ($agent) {
                $query->where('agent_id', $agent->id);
            })->orderBy('date_admission', 'desc')->paginate($limit);
        }

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(), "title"=>$data['title'], "text"=>$data['mensaje'], "status"=>$data['status']]);

    }

    public function updateClient(Request $request)
    {
        $data = $this->clientService->updateClient($request);

        $myRoles = $this->rolesService->getMyRoles();

        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();
        $limit = $request->input('limit', 10); // Por defecto muestra 10 registros

        if ($myRoles['roles']== 'ADMINISTRADOR') {

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
                'latestDeposit'
            ])->orderBy('date_admission', 'desc')->paginate($limit);

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
                'latestDeposit'
            ])->whereHas('assignaments', function($query) use ($agent) {
                $query->where('agent_id', $agent->id);
            })->orderBy('date_admission', 'desc')->paginate($limit);
        }

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(), "title"=>$data['title'], "text"=>$data['mensaje'], "status"=>$data['status']]);
    }

    public function updateClientProfile(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
    
        try {
            if (empty($request->name) || empty($request->lastname) || empty($request->phone) || empty($request->email)) {
                throw new Exception("Nombre, apellido, teléfono y correo son obligatorios.");
            }
            $client = Customers::find($request->id);
            if (!$client) {
                throw new Exception("Cliente no encontrado.");
            }
            $emailExists = Customers::where('email', $request->email)
                ->where('id', '!=', $client->id)
                ->exists();
    
            if ($emailExists) {
                throw new Exception("El correo electrónico ya está registrado en otro cliente.");
            }
            $phoneExists = Customers::where('phone', $request->phone)
                ->where('id', '!=', $client->id)
                ->exists();
    
            if ($phoneExists) {
                throw new Exception("El número de teléfono ya está registrado en otro cliente.");
            }
    
            $client->name = $request->name;
            $client->lastname = $request->lastname;
            $client->phone = $request->phone;
            $client->optional_phone = $request->optionalPhone ?? null;
            $client->country = $request->country ?? null;
            $client->comment = $request->comment ?? null;
            $client->email = $request->email;
    
            $user = User::find($client->user_id);
            if ($user) {
                $user->name = $request->name;
            }
    
            if ($client->save()) {
                if ($user && !$user->save()) {
                    throw new Exception("Hubo un error al actualizar el usuario del cliente.");
                }
                $title = "Correcto";
                $mensaje = "Se actualizó el cliente correctamente.";
                $status = "success";
            } else {
                throw new Exception("Hubo un error al actualizar el cliente.");
            }
    
        } catch (ValidationException $e) {
            $mensaje = $e->getMessage();
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
        }

        $dataCustomer = Customers::where('id', $request->id)->first();

        return response()->json(["view"=>view('cliente.components.dataClients', compact('dataCustomer'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    
    }

    public function deleteClient(Request $request)
    {
        $data = $this->clientService->deleteClient($request);

        $myRoles = $this->rolesService->getMyRoles();

        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();
        $limit = $request->input('limit', 10); // Por defecto muestra 10 registros

        if ($myRoles['roles']== 'ADMINISTRADOR') {

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
                'latestDeposit'
            ])->orderBy('date_admission', 'desc')->paginate($limit);

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
                'latestDeposit'
            ])->whereHas('assignaments', function($query) use ($agent) {
                $query->where('agent_id', $agent->id);
            })->orderBy('date_admission', 'desc')->paginate($limit);
        }

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(), "title"=>$data['title'], "text"=>$data['mensaje'], "status"=>$data['status']]);

    }

    public function descargarArchivo()
    {
        $archivo = public_path('utils/CARGA_MASIVA_DE_CLNT.xlsx');

        return response()->download($archivo, 'CARGA_MASIVA_DE_CLNT.xlsx', [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function uploadExcel(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        $myRoles = $this->rolesService->getMyRoles();
        $agent = $this->agentService->getAgent();
        $customers = $this->getClients($myRoles['roles'], $agent);
        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        if (!$request->hasFile('file')) {
            return response()->json([
                "view" => view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(),
                "title" => "Error",
                "text" => "Adjuntar un archivo",
                "status" => "error"
            ]);
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return response()->json([
                "view" => view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(),
                "title" => "Error",
                "text" => "Archivo Invalido",
                "status" => "error"
            ]);
        }

        try {
            Excel::import(new CustomersImport, $file);
            return response()->json([
                "view" => view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(),
                "title" => "Correcto",
                "text" => "El cliente se importó correctamente",
                "status" => "success"
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();

            return response()->json([
                "view" => view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(),
                "title" => "Error en la validación",
                "text" => "Errores encontrados: " . implode(', ', array_merge(...array_values($errors))),
                "status" => "error"
            ]);
        } catch (Exception $e) {
            return response()->json([
                "view" => view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(),
                "title" => "Error",
                "text" => $e->getMessage(),
                "status" => "error"
            ]);
        }
    }

    public function profileClient($id) {
        $data = $this->clientService->profileClient($id);
        return view('cliente.profile', $data);
    }

    public function saveConfigTable(Request $request) {

        $estadoDateInit = "active";
        $estadoCode = "active";
        $estadoPhone = "active";
        $estadoOptionalPhone = "active";
        $estadoEmail = "active";
        $estadoCity = "active";
        $estadoCountry = "active";
        $estadoComment = "active";

        if ($request->configTablesDateInit != "true") {
            $estadoDateInit = 'inactive';
        }

        try {

            $user = Auth::user();
            $user_id = $user->id;

            $configTablesDateInit = Configuration::where('user_id', $user_id)
                                        ->where('view', 'tabClient')
                                        ->where('name', 'date_init')
                                        ->first();

            $configTablesDateInit->status = $estadoDateInit;
            if ($configTablesDateInit->save()) {

                $configTablesCode = Configuration::where('user_id', $user_id)
                                        ->where('view', 'tabClient')
                                        ->where('name', 'code')
                                        ->first();

                $configTablesCode->status = $request->configTablesCode == "true" ? 'active': 'inactive';
                if ($configTablesCode->save()) {
                    $configTablesPhone = Configuration::where('user_id', $user_id)
                                        ->where('view', 'tabClient')
                                        ->where('name', 'phone')
                                        ->first();

                    $configTablesPhone->status = $request->configTablesPhone == "true" ? 'active': 'inactive';
                    if ($configTablesPhone->save()) {
                        $configTablesOptionalPhone = Configuration::where('user_id', $user_id)
                                        ->where('view', 'tabClient')
                                        ->where('name', 'optional_phone')
                                        ->first();

                        $configTablesOptionalPhone->status = $request->configTablesOptionalPhone == "true" ? 'active': 'inactive';
                        if ($configTablesOptionalPhone->save()) {
                            $configTablesEmail = Configuration::where('user_id', $user_id)
                                        ->where('view', 'tabClient')
                                        ->where('name', 'email')
                                        ->first();

                            $configTablesEmail->status = $request->configTablesEmail == "true" ? 'active': 'inactive';
                            if ($configTablesEmail->save()) {
                                $configTablesCity = Configuration::where('user_id', $user_id)
                                        ->where('view', 'tabClient')
                                        ->where('name', 'city')
                                        ->first();

                                $configTablesCity->status = $request->configTablesCity == "true" ? 'active': 'inactive';

                                if ($configTablesCity->save()) {
                                    $configTablesCountry = Configuration::where('user_id', $user_id)
                                        ->where('view', 'tabClient')
                                        ->where('name', 'country')
                                        ->first();

                                    $configTablesCountry->status = $request->configTablesCountry == "true" ? 'active': 'inactive';
                                    if ($configTablesCountry->save()) {
                                        $configTablesComment = Configuration::where('user_id', $user_id)
                                        ->where('view', 'tabClient')
                                        ->where('name', 'comment')
                                        ->first();

                                        $configTablesComment->status = $request->configTablesComment == "true" ? 'active': 'inactive';
                                        if ($configTablesComment->save()) {

                                        }

                                    }

                                }

                            }

                        }

                    }

                }


            }

            $title = "Correcto";
            $mensaje = "Tabla personalizada";
            $status = "success";
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = "Ocurrió un error: " . $e->getMessage();
            $status = "error";
        }

        $customers = Customers::orderBy('date_admission')->get();

        $configTablesDateInit = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'date_init')
                                     ->first();

        $configTablesCode = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'code')
                                     ->first();

        $configTablesPhone = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'phone')
                                     ->first();

        $configTablesOptionalPhone = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'optional_phone')
                                     ->first();

        $configTablesEmail = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'email')
                                     ->first();

        $configTablesCity = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'city')
                                     ->first();

        $configTablesCountry = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'country')
                                     ->first();

        $configTablesComment = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'comment')
                                     ->first();

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'configTablesDateInit', 'configTablesCode', 'configTablesPhone', 'configTablesOptionalPhone', 'configTablesEmail', 'configTablesCity', 'configTablesCountry', 'configTablesComment', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function filterOrder(Request $request) {
        $order = $request->order;
        $type = $request->type ?? 'asc'; // Orden ascendente por defecto
    
        $myRoles = $this->rolesService->getMyRoles();
        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();
    
        // Lista de columnas permitidas en customers
        $allowedColumns = [
            'id', 'code', 'name', 'lastname', 'phone', 'date_admission', 'status',
            'email', 'created_at', 'updated_at'
        ];
    
        // Validar que $order sea una columna válida
        if (!in_array($order, $allowedColumns) && !in_array($order, ['comunications.date', 'latestAssignamet.date'])) {
            $order = 'created_at'; // Orden por defecto
        }
    
        // Construir consulta base
        $query = Customers::with([
            'user', 'agent', 'latestCampaign', 'latestSupplier',
            'provider', 'statusCustomer', 'platform', 'traiding',
            'latestComunication', 'latestAssignamet', 'latestDeposit'
        ]);
    
        // Si no es ADMIN, filtrar por agente
        if ($myRoles['roles'] !== 'ADMINISTRADOR') {
            $query->whereHas('assignaments', function ($q) use ($agent) {
                $q->where('agent_id', $agent->id);
            });
        }
    
        // Manejo de ordenamiento especial para relaciones
        if ($order == 'comunications.date') {
            $query->orderByRaw("
                (SELECT date FROM comunications 
                WHERE comunications.customer_id = customers.id 
                ORDER BY date DESC LIMIT 1) $type
            ");
        } elseif ($order == 'latestAssignamet.date') {
            $query->orderByRaw("
                (SELECT date FROM assignments 
                WHERE assignments.customer_id = customers.id 
                ORDER BY date DESC LIMIT 1) $type
            ");
        } else {
            $query->orderBy($order, $type);
        }
    
        // Paginar resultados
        $customers = $query->paginate(50);
    
        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();
    
        return response()->json([
            "view" => view('cliente.list.listCustomer', compact(
                'customers', 'agents', 'campaings', 'providers', 'statusCustomers'
            ))->render()
        ]);
    }
    
    public function filterByAttr(Request $request) {
        $id = $request->id;
        $type = $request->type;

        $myRoles = $this->rolesService->getMyRoles();
        $myRolesId = $myRoles['rolesId'];
        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();
        $limit = $request->input('limit', 10); // Por defecto muestra 10 registros

        if ($myRoles['roles']== 'ADMINISTRADOR') {

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
                'latestDeposit'
            ])->where($type, $id)->paginate($limit);

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
                'latestDeposit'
            ])->whereHas('assignaments', function($query) use ($agent) {
                $query->where('agent_id', $agent->id);
            })->where($type, $id)->orderBy('date_admission', 'desc')->paginate($limit);

        }

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        dd($customers);

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render()]);
    }

    public function filterByDate(Request $request) {
        $order = $request->order;
        $type = $request->type;

        $formattedDate = Carbon::now()->format('Y-m-d');

        $myRoles = $this->rolesService->getMyRoles();
        $myRolesId = $myRoles['rolesId'];
        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();
        $limit = $request->input('limit', 10); // Por defecto muestra 10 registros

        if ($myRoles['roles']== 'ADMINISTRADOR') {

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
                'latestDeposit'
            ])->whereBetween($order, [$formattedDate, $formattedDate])->paginate($limit);

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
                'latestDeposit'
            ])->whereHas('assignaments', function($query) use ($agent) {
                $query->where('agent_id', $agent->id);
            })->whereBetween($order, [$formattedDate, $formattedDate])->orderBy('date_admission', 'desc')->paginate($limit);

        }

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render()]);
    }

    public function searchGeneralClient(Request $request) {

        $customerStatusId = $request->customerStatusId;
        $dateInit = Carbon::createFromFormat('m/d/Y', $request->dateInit)->format('Y-m-d');
        $dateEnd = Carbon::createFromFormat('m/d/Y', $request->dateEnd)->format('Y-m-d');
        $limit = $request->input('limit', 10); // Por defecto muestra 10 registros

        $data = $request->data;
        $myRoles = $this->rolesService->getMyRoles();
        $myRolesId = $myRoles['rolesId'];
        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();

        if ($myRoles['roles']== 'ADMINISTRADOR') {

            $query = Customers::with([
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
                'latestDeposit'
            ]);

            // Filtro por rango de fechas si ambos parámetros están presentes
            if ($dateInit && $dateEnd) {
                $query->whereBetween('date_admission', [$dateInit, $dateEnd]);
            }

            // Filtro por estado del cliente si está presente
            if ($customerStatusId !== "Seleccione un estado") {
                $query->where('id_status', $customerStatusId);
            }

            // Filtro por coincidencia en id, code, name o lastname si 'data' tiene un valor
            if ($data) {
                $query->where(function($q) use ($data) {
                    $q->where('id', 'like', "%$data%")
                    ->orWhere('code', 'like', "%$data%")
                    ->orWhere('name', 'like', "%$data%")
                    ->orWhere('lastname', 'like', "%$data%");
                });
            }

            // Ejecutar la consulta y paginar los resultados
            $customers = $query->paginate($limit);

        } else {

            // Crear una consulta base
            $query = Customers::with([
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
                'latestDeposit'
            ]);

            // Filtro por asignación del agente si está presente
            if ($agent->id) {
                $query->whereHas('assignaments', function($q) use ($agent) {
                    $q->where('agent_id', $agent->id);
                });
            }

            // Filtro por rango de fechas si ambos parámetros están presentes
            if ($dateInit && $dateEnd) {
                $query->whereBetween('date_admission', [$dateInit, $dateEnd]);
            }

            // Filtro por estado del cliente si está presente y es una relación
            if ($customerStatusId !== "Seleccione un estado") {
                $query->where('id_status', $customerStatusId);
            }


            // Filtro por coincidencia en id, code, name o lastname si 'data' tiene un valor
            if ($data) {
                $query->where(function($q) use ($data) {
                    $q->where('id', 'like', "%$data%")
                    ->orWhere('code', 'like', "%$data%")
                    ->orWhere('name', 'like', "%$data%")
                    ->orWhere('lastname', 'like', "%$data%");
                });
            }

            // Ordenar por fecha de admisión y paginar los resultados
            $customers = $query->orderBy('date_admission', 'desc')->paginate($limit);

        }

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render()]);

    }

    public function liberarCliente(Request $request) {
        $title = 'Error';
        $mensaje = 'Error desconocido';
        $status = 'error';
        $limit = $request->input('limit', 10); // Por defecto muestra 10 registros

        try {

            foreach ($request->idGroupClientes as $idClient) {

                $assignment = Assignment::where('customer_id', $idClient)
                                        ->where('status', 1)
                                        ->first();

                if ($assignment) {
                    $assignment->status = 0;
                    $assignment->save();

                    $title = "Correcto";
                    $mensaje = "Actualización correcta";
                    $status = "success";

                } else {

                    $title = "Error";
                    $mensaje = "Asignación erronea";
                    $status = "error";

                }

            }

        } catch (Exception $e) {
            $title = "Error";
            $mensaje = "Ocurrió un error: " . $e->getMessage();
            $status = "error";
        }

        $myRoles = $this->rolesService->getMyRoles();
        $myRolesId = $myRoles['rolesId'];
        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();

        if ($myRoles['roles']== 'ADMINISTRADOR') {

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
                'latestDeposit'
            ])->orderBy('date_admission', 'desc')->paginate($limit);

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
                'latestDeposit'
            ])->whereHas('assignaments', function($query) use ($agent) {
                $query->where('agent_id', $agent->id);
            })->orderBy('date_admission', 'desc')->paginate($limit);
        }

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);

    }

    public function saveEventClient(Request $request) {
        $title = 'Error';
        $mensaje = 'Error desconocido';
        $status = 'error';

        $idClient = $request->idClient;
        $date = date("Y-m-d", strtotime($request->date));
        $nameEvent = $request->nameEvent;
        $description = $request->description;
        $dniClient = $request->dniClient;
        $codeAgent = $request->codeAgent;
        $hourInit = $request->hourInit;
        $hourEnd = $request->hourEnd;
        $idPriority = $request->idPriority;
        $resp = 0;
        $user_id = Auth::user()->id;
        $agentRegister = Agent::where('user_id', $user_id)->first();
        $priority = Priority::where('id', $request->idPriority)->first();
        $client = Customers::where('code', $request->dniClient)->first();

        if ($codeAgent) {
            $agent = Agent::where('code_voiso', $request->codeAgent)->first();
        }

        try {
            $task = new Task();
            $task->name = $nameEvent;
            $task->description = $description;
            $task->document = '';
            $task->timeStart = $hourInit;
            $task->timeEnd = $hourEnd;
            $task->date = $date;
            $task->agent_id = $agent->id;
            $task->priority_id = $priority->id;
            $task->customer_id = $idClient;
            $task->start = $date ." ".$hourInit;
            $task->end = $date ." ".$hourEnd;
            if ($task->save()) {
                $title = "Correcto";
                $mensaje = "El evento se creó correctamente";
                $status = "success";
            }
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        $eventos = Task::with(['customer', 'agent', 'priority'])->where('customer_id', $idClient)->orderBy('date', 'desc')->get();
        // Iteramos cada evento para asignar la fecha formateada
        $eventos->each(function ($evento) {
            $evento->formatted_date = $this->dateService->formatDate($evento->date);
        });

        return response()->json(["view"=>view('cliente.list.tabTaskClient', compact('eventos'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function resetTableConfig(Request $request)
    {
        try {
            $user = Auth::user();
            $scope = $request->scope; // "user" o "role"
            $roleId = $request->role_id ?? null;

            if ($scope === "user") {
                // Eliminar configuración de la tabla para el usuario actual
                Configuration::where('user_id', $user->id)
                            ->where('view', 'tabClient')
                            ->delete();
            } elseif ($scope === "role" && $roleId) {
                // Eliminar configuración de la tabla para el rol seleccionado
                Configuration::where('role_id', $roleId)
                            ->where('view', 'tabClient')
                            ->delete();
            } else {
                return response()->json([
                    "status" => "error",
                    "message" => "Error en el alcance seleccionado."
                ], 400);
            }

            return response()->json([
                "status" => "success",
                "message" => "La configuración se ha restablecido correctamente."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Error al restablecer la configuración: " . $e->getMessage()
            ], 500);
        }
    }

}
