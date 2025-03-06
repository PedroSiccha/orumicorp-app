<?php
namespace App\Services;

use App\DTOs\ClientIndexDTO;
use App\Helpers\ResponseHelper;
use App\Http\Requests\FilterRequest;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Interfaces\AwardRepositoryInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\ConfigurationRepositoryInterface;
use App\Interfaces\RolesInterface;
use App\Models\User;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\CampaingRepositoryInterface;
use App\Interfaces\ComunicationRepositoryInterface;
use App\Interfaces\EventRepositoryInterface;
use App\Interfaces\FolderRepositoryInterface;
use App\Interfaces\PlatformRepositoryInterface;
use App\Interfaces\PriorityRepositoryInterface;
use App\Interfaces\ProviderRepositoryInterface;
use App\Interfaces\RolRepositoryInterface;
use App\Interfaces\TraidingRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\ViewsRepositoryInterface;
use App\Repositories\Contracts\AssignmentRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ClientService {

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
    protected $assignmentRepository;
    protected $comunicationRepository;
    protected $viewsRepository;
    protected $priorityRepository;
    protected $taskRepository;
    protected $userRepository;
    protected $clientRepository;

    public function __construct(

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
        AssignmentRepositoryInterface $assignmentRepository,
        ComunicationRepositoryInterface $comunicationRepository,
        ViewsRepositoryInterface $viewsRepository,
        PriorityRepositoryInterface $priorityRepository,
        EventRepositoryInterface $taskRepository,
        ClientRepositoryInterface $clientRepository,
        UserRepositoryInterface $userRepository

    ) {
        
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
        $this->assignmentRepository = $assignmentRepository;
        $this->comunicationRepository = $comunicationRepository;
        $this->viewsRepository = $viewsRepository;
        $this->priorityRepository = $priorityRepository;
        $this->taskRepository = $taskRepository;
        $this->clientRepository = $clientRepository;
        $this->userRepository = $userRepository;
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

            $folders = $this->folderRepository->getFolders();
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

            $dataClient = new StoreCustomerRequest([
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

            // Crear cliente usando el repositorio
            $client = $this->clientRepository->createClient($dataClient);
            DB::commit();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $client]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
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


    public function assignAgent(array $data): array
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        DB::beginTransaction();

        try {
            // Buscar el agente por código o código Voiso
            $agent = $this->agentRepository->findAgentByCode($data['dni_agent']);

            if (!$agent) {
                throw new Exception("Agente no encontrado.");
            }

            $user_id = Auth::user()->id;

            // Obtener y desactivar asignaciones activas
            $oldAssignments = $this->assignmentRepository->getActiveAssignments($data['id']);
            $this->assignmentRepository->desactivateAssignments($oldAssignments);

            // Crear nueva asignación
            $this->assignmentRepository->createAssignment([
                'agent_id' => $agent->id,
                'customer_id' => $data['id'],
                'date' => Carbon::now(),
                'assignated_by_id' => $user_id,
                'status' => 1
            ]);

            DB::commit();

            $title = "Correcto";
            $mensaje = "Se asignó correctamente el agente";
            $status = "success";

        } catch (Exception $e) {
            DB::rollBack();

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

    public function assignGroupAgent(array $data): array
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        DB::beginTransaction();

        try {
            // Buscar el agente por código o código Voiso
            $agent = $this->agentRepository->findAgentByCode($data['dni_agent']);

            if (!$agent) {
                throw new Exception("Agente no encontrado.");
            }

            $user_id = Auth::user()->id;

            // Proceso de asignación en batch
            $assignments = [];

            foreach ($data['idGroupClientes'] as $idClient) {
                // Obtener y desactivar asignaciones activas
                $oldAssignments = $this->assignmentRepository->getActiveAssignments($idClient);
                $this->assignmentRepository->desactivateAssignments($oldAssignments);

                // Agregar a la lista de asignaciones
                $assignments[] = [
                    'agent_id' => $agent->id,
                    'customer_id' => $idClient,
                    'date' => Carbon::now(),
                    'assignated_by_id' => $user_id,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            // Insertar en batch
            $this->assignmentRepository->createAssignments($assignments);

            DB::commit();

            $title = "Correcto";
            $mensaje = "Se asignó correctamente el agente";
            $status = "success";

        } catch (Exception $e) {
            DB::rollBack();

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

    public function getLastAssignmentByCustomer(array $data)
    {
        try {
            $customerId = $data['customer_id'];

            $lastAssignment = $this->assignmentRepository->getLastAssignamentByCustomer($customerId);

            if ($lastAssignment) {
                return [
                    'status' => 'success',
                    'data' => $lastAssignment,
                ];
            }

            return [
                'status' => 'error',
                'message' => 'No assignments found for this customer',
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function changeStatusGroup(array $data)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {
            // Actualizar estado de los clientes
            $this->clientRepository->updateStatus($data['idGroupClientes'], $data['statusId']);

            $title = "Correcto";
            $mensaje = "Actualización correcta";
            $status = "success";
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = "Ocurrió un error: " . $e->getMessage();
            $status = "error";
        }

        return [
            "title" => $title,
            "text" => $mensaje,
            "status" => $status
        ];
    }

    public function changeStatusClient(array $data): array
    {

        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        
        try {
            $client = $this->clientRepository->getClientById($data['id']);

            if (!$client) {
                return [
                    'title' => "Error",
                    'mensaje' => "Cliente no encontrado",
                    'status' => "error"
                ];
            }

            $updated = $this->clientRepository->updateClientStatus($data['id'], $data['status']);

            if ($updated) {
                $title = "Correcto";
                $mensaje = "Se cambió el estado del cliente";
                $status = "success";
            } else {
                $mensaje = "No se pudo cambiar el estado del cliente";
            }

        } catch (Exception $e) {
            Log::error("Error en `changeStatusClient()`: " . $e->getMessage());
            $mensaje = "Ocurrió un error inesperado. Por favor, contacte al soporte.";
        }

        return [
            'title' => $title,
            'mensaje' => $mensaje,
            'status' => $status
        ];
    }

    public function updateClient($request)
    {
        $dataClient = new StoreClientRequest([
                'code' => $request->code,
                'name' => $request->name,
                'lastname' => $request->lastname,
                'phone' => $request->phone,
                'optional_phone' => $request->optionalPhone,
                'city' => $request->city,
                'country' => $request->country,
                'comment' => $request->comment,
                'email' => $request->email
        ]);
        DB::beginTransaction();
        try {
            $client = $this->clientRepository->getClientById($request->id);
            $this->clientRepository->updateClient($client, $dataClient);

            DB::commit();

            return [
                'title' => 'Correcto',
                'mensaje' => 'Se actualizó el cliente correctamente',
                'status' => 'success'
            ];

        } catch (Exception $e) {
            DB::rollBack();
            return [
                'title' => 'Error',
                'mensaje' => 'Error al actualizar cliente: ' . $e->getMessage(),
                'status' => 'error'
            ];
        }
    }

    public function deleteClient($request)
    {
        DB::beginTransaction();
        try {
            $client = $this->clientRepository->getClientById($request->id);
            if (!$client) { 
                return [
                    'title' => 'Error',
                    'mensaje' => 'Cliente no encontrado',
                    'status' => 'error'
                ];
            }
            if ($this->clientRepository->deleteClient($client)) {
                DB::commit();
                return [
                    'title' => 'Correcto',
                    'mensaje' => 'El cliente se eliminó correctamente',
                    'status' => 'success'
                ];
            } else {
                DB::rollBack();
                return [
                    'title' => 'Error',
                    'mensaje' => 'No se pudo eliminar el cliente',
                    'status' => 'error'
                ];
            }
        } catch (Exception $e) {
            DB::rollBack();

            return [
                'title' => 'Error',
                'mensaje' => 'Error al eliminar el cliente: ' . $e->getMessage(),
                'status' => 'error'
            ];
        }
    }

    public function profileClient($id) {

        $myRoles = $this->rolesService->getMyRoles();
        $client = $this->clientRepository->getClientByUserId($id);
        $dataUser = $client;

        $communications = $this->comunicationRepository->getLocationByCustomer($client->id);
        $lastAssignament = $this->assignmentRepository->getLastAssignamentByCustomer($client->id);
        $lastCampaing = $this->campaingRepository->getLastCampaingByCustomer($client->id);
        $campaings = $this->campaingRepository->getAllCampaingsByCustomer($client->id);
        $lastProvider = $this->providerRepository->getLastProviderByCustomer($client->id);
        $providers = $this->providerRepository->getAllProvidersByCustomer($client->id);
        $priorities = $this->priorityRepository->getAllPriorities();
        $eventos = $this->taskRepository->getEventsByCustomer($client->id);
        $vistas = $this->viewsRepository->getViewsByClients($client->id);

        return compact('rouletteSpin', 'dataUser', 'premios1', 'premios2', 'dataCustomer', 'communications', 'lastAssignament', 'lastCampaing', 'campaings', 'lastProvider', 'providers', 'priorities', 'eventos', 'vistas');

    }

    public function searchCustomerByStatus($customerId)
    {
        $myRoles = $this->rolesService->getMyRoles();
        $userId = $this->userRepository->getMyId();
        $roles = $myRoles['roles'];
        // Obtener el agente si no es ADMIN
        $agent = ($roles !== 'ADMINISTRADOR') ? $this->agentRepository->getAgentByUserId($userId) : null; // Agent::where('user_id', $userId)->first() : null;
        $agentId = $agent ? $agent->id : null;

        // Obtener clientes según el rol
        $customers = $this->clientRepository->getCustomersByStatusAndRole($customerId, $roles, $agentId);

        // Obtener datos adicionales
        $agents = $this->agentRepository->getAgents(); // Agent::all();
        $campaings = $this->campaingRepository->getCampaing(); // Campaing::all();
        $providers = $this->providerRepository->getProviders(); // Provider::all();
        $statusCustomers = $this->clientRepository->getCustomerStatus();

        return compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers');
    }

    public function filterAdvanced(FilterRequest $request)
    {
        

        // $query = Customers::with([
        //     'user',
        //     'agent',
        //     'latestCampaign',
        //     'latestSupplier',
        //     'provider',
        //     'statusCustomer',
        //     'platform',
        //     'traiding',
        //     'latestComunication',
        //     'latestAssignamet',
        //     'latestDeposit',
        //     'folder'
        // ]);

        // if ($filterFor !== 'Filtrar Por:' || $inputName !== '') {
        //     if ($filterFor == 'Cod. Cliente') {
        //         $query->where(function($q) use ($inputName) {
        //             $q->where('code', 'like', "%$inputName%");
        //         });
        //     }

        //     if ($filterFor == 'Asignado Por') {
        //         $query->whereHas('assignaments', function($q) use ($inputName) {
        //             $q->whereHas('assignedBy', function($a) use ($inputName) {
        //                 $a->where('name', 'like', "%$inputName%")->orWhere('lastname', 'like', "%$inputName%");
        //             });
        //         });
        //     }

        //     if ($filterFor == 'Proveedor') {
        //         $query->whereHas('provider', function($q) use ($inputName) {
        //             $q->where('name', $inputName);
        //         });
        //     }

        //     if ($filterFor == 'Nombre Cliente') {
        //         $query->where(function($q) use ($inputName) {
        //             $q->where('name', 'like', "%$inputName%")->orWhere('lastname', 'like', "%$inputName%");
        //         });
        //     }

        //     if ($filterFor == 'Correo') {
        //         $query->where(function($q) use ($inputName) {
        //             $q->where('email', 'like', "%$inputName%");
        //         });
        //     }

        //     if ($filterFor == 'Teléfono') {
        //         $query->where(function($q) use ($inputName) {
        //             $q->where('phone', 'like', "%$inputName%");
        //         });
        //     }

        //     if ($filterFor == 'Teléfono Opcional') {
        //         $query->where(function($q) use ($inputName) {
        //             $q->where('optional_phone', 'like', "%$inputName%");
        //         });
        //     }

        //     if ($filterFor == 'Ciudad') {
        //         $query->where(function($q) use ($inputName) {
        //             $q->where('city', 'like', "%$inputName%");
        //         });
        //     }

        //     if ($filterFor == 'País') {
        //         $query->where(function($q) use ($inputName) {
        //             $q->where('country', 'like', "%$inputName%");
        //         });
        //     }

        //     if ($filterFor == 'Agente') {
        //         $query->whereHas('assignaments', function($q) use ($inputName) {
        //             $q->whereHas('agent', function($a) use ($inputName) {
        //                 $a->where('name', 'like', "%$inputName%")->orWhere('lastname', 'like', "%$inputName%");
        //             });
        //         });
        //     }

        //     if ($filterFor == 'Comentario') {
        //         $query->where(function($q) use ($inputName) {
        //             $q->where('comment', 'like', "%$inputName%");
        //         });
        //     }

        //     if ($filterFor == 'Última Visita') {
        //         $query->whereHas('views', function($q) use ($inputName) {
        //             $q->whereHas('agent', function($a) use ($inputName) {
        //                 $a->where('name', 'like', "%$inputName%")->orWhere('lastname', 'like', "%$inputName%");
        //             });
        //         });
        //     }

        //     if ($filterFor == 'N° Depósito') {
        //         $dataSearch = 'code';
        //     }

        //     if ($filterFor == 'Total Depósito') {
        //         $dataSearch = 'code';
        //     }

        //     if ($filterFor == 'Folder') {
        //         $query->whereHas('folder', function($q) use ($inputName) {
        //             $q->where('name', 'like', "%$inputName%");
        //         });
        //     }

        // }

        // if ($statusId !== "Seleccione un estado") {
        //     $query->where('id_status', $statusId);
        // }

        // if ($typeRange !== "Seleccione Rango:") {

        //     if ($typeRange == "Última Llamada") {
        //         if (!empty($dateInit) && !empty($dateEnd) && $dateInit <= $dateEnd) {
        //             $query->whereHas('comunications', function ($q) use ($dateInit, $dateEnd) {
        //                 $q->whereBetween('date', [$dateInit, $dateEnd]);
        //             });
        //         }
        //     }

        //     if ($typeRange == "Fecha de Ingreso") {
        //         $query->whereBetween('date_admission', [$dateInit, $dateEnd]);
        //     }

        //     if ($typeRange == "Fecha de Última Llamada") {
        //         if (!empty($dateInit) && !empty($dateEnd) && $dateInit <= $dateEnd) {
        //             $query->whereHas('comunications', function ($q) use ($dateInit, $dateEnd) {
        //                 $q->whereBetween('date', [$dateInit, $dateEnd]);
        //             });
        //         }
        //     }

        //     if ($typeRange == "Fecha de Última Asignación") {
        //         if (!empty($dateInit) && !empty($dateEnd) && $dateInit <= $dateEnd) {
        //             $query->whereHas('assignaments', function ($q) use ($dateInit, $dateEnd) {
        //                 $q->whereBetween('date', [$dateInit, $dateEnd]);
        //             });

        //         }
        //     }


        //     // $query->where('id_status', $statusId);
        // }

        // $customers = $query->paginate(10);

        // $agents = Agent::all();
        // $campaings = Campaing::all();
        // $providers = Provider::all();
        // $statusCustomers = CustomerStatus::all();

        // return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render()]);

    }

}
