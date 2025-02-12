<?php
namespace App\Services;

use App\DTOs\ClientIndexDTO;
use App\Exceptions\RepositoryException;
use App\Interfaces\AssignamentInterface;
use App\Interfaces\AwardRepositoryInterface;
use App\Interfaces\CampaingInterface;
use App\Interfaces\ClientInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\ComunicationInterface;
use App\Interfaces\ConfigurationRepositoryInterface;
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
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\CampaingRepositoryInterface;

use App\Interfaces\FolderRepositoryInterface;
use App\Interfaces\PlatformRepositoryInterface;
use App\Interfaces\ProviderRepositoryInterface;
use App\Interfaces\RolRepositoryInterface;
use App\Interfaces\TraidingRepositoryInterface;
use App\Rules\PhoneNumberFormat;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ClientService /*implements ClientInterface*/ {
    // protected $userService;
    protected $rolesService;
    protected $agentRepository;
    protected $rolRepository;
    protected $configurationRepository;
    protected $providerRepository;
    protected $platformRepository;
    protected $traidingRepository;
    protected $folderRepository;
    protected $campaingRepository;
    protected $awardRepository;

    // protected $awardsService;
    // protected $communicationService;
    // protected $assignamentService;
    // protected $campaingService;
    // protected $providerService;
    // protected $utils;

    protected $clientRepository;

    public function __construct(
        // UserInterface $userService,
        RolesInterface $rolesService,
        AgentRepositoryInterface $agentRepository,
        RolRepositoryInterface $rolRepository,
        ProviderRepositoryInterface $providerRepository,
        PlatformRepositoryInterface $platformRepository,
        TraidingRepositoryInterface $traidingRepository,
        FolderRepositoryInterface $folderRepository,
        CampaingRepositoryInterface $campaingRepository,
        ConfigurationRepositoryInterface $configurationRepository,
        AwardRepositoryInterface $awardRepository,
        // AwardsService $awardsService,
        // ComunicationInterface $communicationService,
        // AssignamentInterface $assignamentService,
        // CampaingInterface $campaingService,
        // ProviderInterface $providerService,
        // Utils $utils,

        ClientRepositoryInterface $clientRepository
    ) {
        // $this->userService = $userService;
        $this->rolesService = $rolesService;
        $this->agentRepository = $agentRepository;
        $this->rolRepository = $rolRepository;
        $this->providerRepository = $providerRepository;
        $this->platformRepository = $platformRepository;
        $this->traidingRepository = $traidingRepository;
        $this->folderRepository = $folderRepository;
        $this->campaingRepository = $campaingRepository;
        $this->configurationRepository = $configurationRepository;
        $this->awardRepository = $awardRepository;
        // $this->awardsService = $awardsService;
        // $this->communicationService = $communicationService;
        // $this->assignamentService = $assignamentService;
        // $this->campaingService = $campaingService;
        // $this->providerService = $providerService;
        // $this->utils = $utils;

        $this->clientRepository = $clientRepository;
    }

    public function getClientsData(): ClientIndexDTO
    {
        try {
            $myRoles = $this->rolesService->getMyRoles();
            $user_id = Auth::user()->id;
            $agent = $this->agentRepository->getAgentByUserId($user_id);
            $rouletteSpin = $agent->number_turns ?: 0;
            $dataUser = $agent;

            $relations = [
                'user', 'agent', 'latestCampaign', 'latestSupplier',
                'provider', 'statusCustomer', 'platform', 'traiding',
                'latestComunication', 'latestAssignamet', 'latestDeposit', 'folder'
            ];

            if ($myRoles['roles'] == 'ADMINISTRADOR') {
                $customers = $this->clientRepository->getAllClients(10, $relations);
            } else {
                if (!$agent) {
                    throw new Exception("El usuario no tiene un agente asignado.");
                }
                $customers = $this->clientRepository->getClientsByAgent($agent->id, 10, $relations);
            }

            $statusCustomers = $this->clientRepository->getAllStatusCustomers();
            $asignCustomers = $this->clientRepository->getUnassignedClients();

            $premios1 = $this->awardRepository->getAwardsByType(1);
            $premios2 = $this->awardRepository->getAwardsByType(2);
            $roles = $this->rolRepository->getAllRoles();

            $providers = $this->providerRepository->getAllProviders();
            $platforms = $this->platformRepository->getAllPlatforms();
            $traidings = $this->traidingRepository->getAllTraidings();

            $folders = $this->folderRepository->getActiveFolders();
            $agents = $this->agentRepository->getAllAgents();
            $campaings = $this->campaingRepository->getAllCampaings();
            if (!isset($myRoles['rolesId'])) {
                Log::error('Error: No se encontró el ID en los roles del usuario', $myRoles);
                throw new Exception("No se pudo obtener el ID del rol del usuario.");
            }
            $myRolesId = $myRoles['rolesId'];

            return new ClientIndexDTO([
                'customers' => $customers,
                'premios1' => $premios1,
                'premios2' => $premios2,
                'roles' => $roles,
                'dataUser' => $dataUser,
                'rouletteSpin' => $rouletteSpin,
                'asignCustomers' => $asignCustomers,
                'myRolesId' => $myRolesId,
                'providers' => $providers,
                'platforms' => $platforms,
                'traidings' => $traidings,
                'statusCustomers' => $statusCustomers,
                'folders' => $folders,
                'agents' => $agents,
                'campaigns' => $campaings
            ]);

        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            throw new Exception("Ocurrió un error inesperado al obtener los datos del cliente.");
        }
    }

    public function saveClient(array $data)
    {
        DB::beginTransaction();

        try {
            // Buscar rol y estado del cliente
            $role = $this->rolRepository->getRoleByName('CLIENTE');
            $statusClient = $this->clientRepository->getStatusByName('NUEVO');

            // Crear usuario
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['name'])
            ]);

            // Asignar rol
            $user->assignRole($role->id);

            // Generar código de cliente
            $code = strtoupper(substr($data['name'], 0, 2) . substr($data['lastname'], 0, 2)) . '_' . $user->id;

            // Crear cliente usando el repositorio
            $client = $this->clientRepository->createClient([
                'code' => $code,
                'name' => $data['name'],
                'lastname' => $data['lastname'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'date_admission' => now(),
                'status' => true,
                'user_id' => $user->id,
                'id_status' => $statusClient->id
            ]);

            DB::commit();

            return response()->json([
                'title' => 'Correcto',
                'mensaje' => 'El cliente se registró correctamente.',
                'status' => 'success',
                'data' => $client
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'title' => 'Error',
                'mensaje' => 'Error inesperado: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function getPaginatedClients(int $limit)
    {
        $myRoles = $this->rolesService->getMyRoles();
        $user_id = Auth::user()->id;
        $agent = $this->agentRepository->getAgentByUserId($user_id);

        $relations = [
            'user', 'agent', 'latestCampaign', 'latestSupplier',
            'provider', 'statusCustomer', 'platform', 'traiding',
            'latestComunication', 'latestAssignamet', 'latestDeposit', 'folder'
        ];

        if ($myRoles['roles'] == 'ADMINISTRADOR') {
            $customers = $this->clientRepository->getAllClients($limit, $relations);
        } else {
            if (!$agent) {
                throw new Exception("El usuario no tiene un agente asignado.");
            }
            $customers = $this->clientRepository->getClientsByAgent($agent->id, $limit, $relations);
        }

        $agents = $this->agentRepository->getAllAgents();
        $campaings = $this->campaingRepository->getAllCampaings();
        $statusCustomers = $this->clientRepository->getAllStatusCustomers();
        $providers = $this->providerRepository->getAllProviders();

        return new ClientIndexDTO([
            'customers' => $customers,
            'campaigns' => $campaings,
            'providers' => $providers,
            'statusCustomers' => $statusCustomers,
            'agents' => $agents
        ]);
    }


    // public function asignAgent($request) {
    //     $title = "Error";
    //     $mensaje = "Error desconocido";
    //     $status = "error";

    //     $agent = Agent::where('code_voiso', $request->dni_agent)
    //                     ->orWhere('code', $request->dni_agent)
    //                     ->first();

    //     $user_id = Auth::user()->id;

    //     try {

    //         $oldAssignments = Assignment::where('customer_id', $request->id)
    //                                     ->where('status', 1)
    //                                     ->get();
    //         foreach ($oldAssignments as $oldAssign) {
    //             $oldAssign->status = 0;
    //             $oldAssign->save();
    //         }

    //         $assignament = new Assignment();
    //         $assignament->agent_id = $agent->id;
    //         $assignament->customer_id = $request->id;
    //         $assignament->date = Carbon::now();
    //         $assignament->assignated_by_id = $user_id;
    //         $assignament->status = 1;
    //         $assignament->save();
    //         // dd($assignament);

    //         $title = "Correcto";
    //         $mensaje = "Se asignó correctamente el agente";
    //         $status = "success";

    //     } catch (Exception $e) {

    //         $title = "Error";
    //         $mensaje = "Ocurrió un error: " . $e->getMessage();
    //         $status = "error";

    //     }

    //     return [
    //         'title' => $title,
    //         'mensaje' => $mensaje,
    //         'status' => $status
    //     ];

    // }

    // public function assignGroupAgent($request) {
    //     $title = "Error";
    //     $mensaje = "Error desconocido";
    //     $status = "error";

    //     $agent = Agent::where('code_voiso', $request->dni_agent)
    //                     ->orWhere('code', $request->dni_agent)
    //                     ->first();

    //     $user_id = Auth::user()->id;

    //     try {
    //         foreach ($request->idGroupClientes as $idClient) {

    //             $oldAssignments = Assignment::where('customer_id', $idClient)
    //                                     ->where('status', 1)
    //                                     ->get();


    //             foreach ($oldAssignments as $oldAssign) {
    //                 $oldAssign->status = 0;
    //                 $oldAssign->save();
    //             }

    //             $assignament = new Assignment();
    //             $assignament->agent_id = $agent->id;
    //             $assignament->customer_id = $idClient;
    //             $assignament->date = Carbon::now();
    //             $assignament->assignated_by_id = $user_id;
    //             $assignament->status = 1;
    //             $assignament->save();

    //         }

    //         $title = "Correcto";
    //         $mensaje = "Se asignó correctamente el agente";
    //         $status = "success";

    //     } catch (Exception $e) {
    //         $title = "Error";
    //         $mensaje = "Ocurrió un error: " . $e->getMessage();
    //         $status = "error";
    //     }

    //     return [
    //         'title' => $title,
    //         'mensaje' => $mensaje,
    //         'status' => $status
    //     ];
    // }

    // public function changeStatusClient($request) {

    //     $title = "Error";
    //     $mensaje = "Error desconocido";
    //     $status = "error";

    //     $idClient = $request->id;
    //     $client = Customers::find($idClient);
    //     if ($client == null) {
    //         $title = "Error";
    //         $mensaje = "Hubo un error con el cliente";
    //         $status = "error";
    //     }
    //     try {
    //         $client->status = $request->status;
    //         if ($client->save()) {
    //             $title = "Correcto";
    //             $mensaje = "Se cambió el estado del cliente";
    //             $status = "success";
    //         } else {
    //             $title = "Error";
    //             $mensaje = "No se pudo cambiar el estado del cliente";
    //             $status = "error";
    //         }
    //     } catch (Exception $e) {
    //         $title = "Error";
    //         $mensaje = "Ocurrió un error: " . $e->getMessage();
    //         $status = "error";
    //     }

    //     return [
    //         'title' => $title,
    //         'mensaje' => $mensaje,
    //         'status' => $status
    //     ];
    // }

    // public function updateClient($request) {
    //     $title = "Error";
    //     $mensaje = "Error desconocido";
    //     $status = "error";

    //     try {

    //         $client = Customers::find($request->id);
    //         $client->code = $request->code;
    //         $client->name = $request->name;
    //         $client->lastname = $request->lastname;
    //         $client->phone = $request->phone;
    //         $client->optional_phone = $request->optionalPhone;
    //         $client->city = $request->city;
    //         $client->country = $request->country;
    //         $client->comment = $request->comment;
    //         $client->email = $request->email;

    //         $user = User::find($client->user_id);
    //         $user->name = $request->name;

    //         if ($client->save()) {
    //             if ($user->save()) {
    //                 $title = "Correcto";
    //                 $mensaje = "Se actualizó el cliente correctamente";
    //                 $status = "success";
    //             } else {
    //                 $title = "Error";
    //                 $mensaje = "Hubo un error al actualizar el usuario del cliente";
    //                 $status = "error";
    //             }
    //         } else {
    //             $title = "Error";
    //             $mensaje = "Hubo un error al actualizar el cliente";
    //             $status = "error";
    //         }

    //     } catch (ValidationException $e) {
    //         $title = "Error";
    //         $mensaje = $e->getMessage();
    //         $status = "error";
    //     } catch (Exception $e) {
    //         $title = "Error";
    //         $mensaje = "Verificar los datos del registro";
    //         $status = "error";
    //     }

    //     return [
    //         'title' => $title,
    //         'mensaje' => $mensaje,
    //         'status' => $status
    //     ];

    // }

    // public function deleteClient($request) {
    //     $title = "Error";
    //     $mensaje = "Error desconocido";
    //     $status = "error";
    //     $client = Customers::find($request->id);
    //     if ($client == null) {
    //         $title = "Error";
    //         $mensaje = "Hubo un error con el cliente";
    //         $status = "error";
    //     }
    //     try {
    //         if ($client->delete()) {
    //             $title = "Correcto";
    //             $mensaje = "El cliente se elimninó correctamente";
    //             $status = "success";
    //         } else {
    //             $title = "Error";
    //             $mensaje = "No se pudo eliminar el cliente";
    //             $status = "error";
    //         }
    //     } catch (Exception $e) {
    //         $title = "Error";
    //         $mensaje = $e->getMessage();
    //         $status = "error";
    //     }

    //     return [
    //         'title' => $title,
    //         'mensaje' => $mensaje,
    //         'status' => $status
    //     ];
    // }

    // public function profileClient($id) {
    //     $myRoles = $this->rolesService->getMyRoles();

    //     $user_id = Auth::user()->id;
    //     $agent = Agent::where('user_id', $user_id)->first();
    //     $client = Customers::where('user_id', $user_id)->first();
    //     $rouletteSpin = $agent->number_turns ?: 0;

    //     $dataUser = null;

    //     if ($agent) {
    //         $dataUser = $agent;
    //     }

    //     if ($client) {
    //         $dataUser = $client;
    //     }

    //     $premios = $this->awardsService->chargeAwards();
    //     $premios1 = $premios['premios1'];
    //     $premios2 = $premios['premios2'];
    //     $dataCustomer = Customers::where('id', $id)->first();
    //     $dataCommunication = [
    //         'customer_id' => $dataCustomer->id,
    //         // 'customerStatusId' => $dataCustomer->customerStatusId
    //     ];

    //     $communications = $this->communicationService->getLocationByCustomer($dataCommunication);
    //     $lastAssignament = $this->assignamentService->getLastAssignamentByCustomer($dataCommunication);
    //     $lastCampaing = $this->campaingService->getLastCampaingByCustomer($dataCommunication);
    //     // dd($lastCampaing);
    //     $campaings = $this->campaingService->getAllCampaingsByCustomer($dataCommunication);
    //     // dd($campaings['name']);
    //     $lastProvider = $this->providerService->getLastProviderByCustomer($dataCommunication);
    //     $providers = $this->providerService->getAllProvidersByCustomer($dataCommunication);
    //     $priorities = Priority::all();
    //     $eventos = Task::with('customer')->where('customer_id', $id)->get();

    //     $vistas = Views::with('agent')
    //                     ->where('customer_id', $dataCustomer->id)
    //                     ->get();

    //     return compact('rouletteSpin', 'dataUser', 'premios1', 'premios2', 'dataCustomer', 'communications', 'lastAssignament', 'lastCampaing', 'campaings', 'lastProvider', 'providers', 'priorities', 'eventos', 'vistas');

    // }

}
