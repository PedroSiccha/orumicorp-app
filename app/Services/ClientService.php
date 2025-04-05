<?php
namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Http\Requests\FilterRequest;
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
use App\Models\Customers;
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
<<<<<<< HEAD
    protected $awardsService;
    protected $communicationService;
    protected $assignamentService;
    protected $campaingService;
    protected $providerService;
    protected $utils;
    protected $dateService;
=======
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
>>>>>>> feature/fix-presentation

    public function __construct(

        RolesInterface $rolesService,
<<<<<<< HEAD
        AwardsService $awardsService,
        ComunicationInterface $communicationService,
        AssignamentInterface $assignamentService,
        CampaingInterface $campaingService,
        ProviderInterface $providerService,
        Utils $utils,
        DateService $dateService
=======
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

>>>>>>> feature/fix-presentation
    ) {
        
        $this->rolesService = $rolesService;
<<<<<<< HEAD
        $this->awardsService = $awardsService;
        $this->communicationService = $communicationService;
        $this->assignamentService = $assignamentService;
        $this->campaingService = $campaingService;
        $this->providerService = $providerService;
        $this->utils = $utils;
        $this->dateService = $dateService;
=======
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
>>>>>>> feature/fix-presentation
    }

    public function getClientsData()
    {
        try {
            $myRoles = $this->rolesService->getMyRoles();
            $user_id = Auth::id();
            $agent = $this->agentRepository->getByUserId($user_id);
            $rouletteSpin = $agent->number_turns ?? 0;

            $relations = [
                'user', 'agent', 'latestCampaign', 'latestSupplier',
                'provider', 'statusCustomer', 'platform', 'traiding',
                'latestComunication', 'latestAssignamet', 'latestDeposit', 'folder'
            ];

            $customers = $this->clientRepository->getCustomersByStatusAndRole(true, $myRoles, $agent->id, 5);

            // Obtener otros datos
            $data = [
                'customers' => $customers,
                'premios1' => $this->awardRepository->getAwardsByType(1),
                'premios2' => $this->awardRepository->getAwardsByType(2),
                'roles' => $this->rolRepository->getAll(),
                'dataUser' => $agent,
                'rouletteSpin' => $rouletteSpin,
                'asignCustomers' => $this->clientRepository->getUnassignedClients(),
                'myRolesId' => $myRoles['rolesId'] ?? throw new Exception("No se pudo obtener el ID del rol del usuario."),
                'providers' => $this->providerRepository->getAll(),
                'platforms' => $this->platformRepository->getAllPlatforms(),
                'traidings' => $this->traidingRepository->getAllTraidings(),
                'statusCustomers' => $this->clientRepository->getCustomerStatus(),
                'folders' => $this->folderRepository->getActiveFolders(),
                'agents' => $this->agentRepository->allActive(),
                'campaigns' => $this->campaingRepository->getAll(),
            ];

            return ResponseHelper::success('Datos obtenidos correctamente.', $data);
        } catch (Exception $e) {
            Log::error("Error en getClientsData: " . $e->getMessage());
            return ResponseHelper::error('Error al obtener los datos del cliente.');
        }
    }


    public function saveClient(array $data)
    {
        DB::beginTransaction();
        try {
            // Buscar rol y estado del cliente
            $role = $this->rolRepository->findByName('CLIENTE');
            $statusClient = $this->clientRepository->getStatusByName('NUEVO');

            // Crear usuario
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['name'])
            ]);

            // Asignar rol al usuario
            $user->assignRole($role->id);

            // Generar código de cliente
            $code = strtoupper(substr($data['name'], 0, 2) . substr($data['lastname'], 0, 2)) . '_' . $user->id;

            // Datos del cliente
            $dataClient = [
                'code' => $code,
                'name' => $data['name'],
                'lastname' => $data['lastname'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'date_admission' => now(),
                'status' => true,
                'user_id' => $user->id,
                'id_status' => $statusClient->id
            ];

            // Crear cliente usando el repositorio
            $client = $this->clientRepository->create($dataClient);

            DB::commit();
            return ResponseHelper::success('Cliente guardado correctamente.', ['client' => $client]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error de validación en saveClient: " . $e->getMessage());
            return ResponseHelper::error('Error en la validación del cliente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en saveClient: " . $e->getMessage());
            return ResponseHelper::error('Error al guardar el cliente.');
        }
    }


    public function getPaginatedClients(int $limit)
    {
        try {
            $myRoles = $this->rolesService->getMyRoles();
            $user_id = Auth::id();
            $agent = $this->agentRepository->getByUserId($user_id);

            $relations = [
                'user', 'agent', 'latestCampaign', 'latestSupplier',
                'provider', 'statusCustomer', 'platform', 'traiding',
                'latestComunication', 'latestAssignamet', 'latestDeposit', 'folder'
            ];

            $customers = $this->clientRepository->getCustomersByStatusAndRole(true, $myRoles, $agent->id, $limit);

            // Obtener otros datos relacionados
            $data = [
                'customers' => $customers,
                'campaigns' => $this->campaingRepository->getAll(),
                'providers' => $this->providerRepository->getAll(),
                'statusCustomers' => $this->clientRepository->getAllStatus(),
                'agents' => $this->agentRepository->allActive()
            ];

            return ResponseHelper::success('Clientes paginados obtenidos correctamente.', $data);
        } catch (Exception $e) {
            Log::error("Error en getPaginatedClients: " . $e->getMessage());
            return ResponseHelper::error('Error al obtener clientes paginados.');
        }
    }



    public function assignAgent(array $data)
    {
        DB::beginTransaction();
        try {
            // Buscar el agente por código o código Voiso
            $agent = $this->agentRepository->getByCode($data['dni_agent']);

            if (!$agent) {
                throw new Exception("Agente no encontrado.");
            }

            $user_id = Auth::id();

            // Obtener y desactivar asignaciones activas
            $oldAssignments = $this->assignmentRepository->getActiveAssignments($data['id']);
            $this->assignmentRepository->deactivateAssignments($oldAssignments);

            // Crear nueva asignación
            $assignment = $this->assignmentRepository->createAssignment([
                'agent_id' => $agent->id,
                'customer_id' => $data['id'],
                'date' => Carbon::now(),
                'assignated_by_id' => $user_id,
                'status' => 1
            ]);

            DB::commit();

            return ResponseHelper::success('Agente asignado correctamente.', ['assignment' => $assignment]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en assignAgent: " . $e->getMessage());

            return ResponseHelper::error('Error al asignar el agente.');
        }
    }


    public function assignGroupAgent(array $data)
    {
        DB::beginTransaction();
        try {
            // Buscar el agente por código o código Voiso
            $agent = $this->agentRepository->getByCode($data['dni_agent']);

            if (!$agent) {
                throw new Exception("Agente no encontrado.");
            }

            $user_id = Auth::id();
            $assignments = [];

            foreach ($data['idGroupClientes'] as $idClient) {
                // Obtener y desactivar asignaciones activas
                $oldAssignments = $this->assignmentRepository->getActiveAssignments($idClient);
                $this->assignmentRepository->deactivateAssignments($oldAssignments);

                // Agregar asignación a la lista para inserción en batch
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

            // Insertar en batch solo si hay asignaciones
            if (!empty($assignments)) {
                $this->assignmentRepository->createAssignments($assignments);
            }

            DB::commit();
            return ResponseHelper::success('Agente asignado correctamente a los clientes.', ['assignments' => $assignments]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en assignGroupAgent: " . $e->getMessage());

            return ResponseHelper::error('Error al asignar el agente a los clientes.');
        }
    }


    public function getLastAssignmentByCustomer(array $data)
    {
        try {
            $customerId = $data['customer_id'];

            // Obtener la última asignación del cliente
            $lastAssignment = $this->assignmentRepository->getLatestActiveAssignmentByCustomer($customerId);

            if (!$lastAssignment) {
                return ResponseHelper::error('No se encontraron asignaciones para este cliente.');
            }

            return ResponseHelper::success('Última asignación obtenida correctamente.', ['assignment' => $lastAssignment]);
        } catch (Exception $e) {
            Log::error("Error en getLastAssignmentByCustomer: " . $e->getMessage());

            return ResponseHelper::error('Error al obtener la última asignación del cliente.');
        }
    }


    public function changeStatusGroup(array $data)
    {
        try {
            // Verificar que la lista de clientes no esté vacía
            if (empty($data['idGroupClientes'])) {
                return ResponseHelper::error('La lista de clientes no puede estar vacía.');
            }

            // Actualizar estado de los clientes
            $this->clientRepository->updateStatus($data['idGroupClientes'], $data['statusId']);

            return ResponseHelper::success('Estado de los clientes actualizado correctamente.');
        } catch (Exception $e) {
            Log::error("Error en changeStatusGroup: " . $e->getMessage());

            return ResponseHelper::error('Error al actualizar el estado de los clientes.');
        }
    }


    public function changeStatusClient(array $data)
    {
        try {
            $client = $this->clientRepository->findById($data['id']);

            if (!$client) {
                return ResponseHelper::error("Cliente no encontrado.");
            }

            // Actualizar el estado del cliente
            $updated = $this->clientRepository->updateClientStatus($data['id'], $data['status']);

            if (!$updated) {
                return ResponseHelper::error("No se pudo cambiar el estado del cliente.");
            }

            return ResponseHelper::success("Estado del cliente actualizado correctamente.", ['client' => $client]);
        } catch (Exception $e) {
            Log::error("Error en changeStatusClient: " . $e->getMessage());

            return ResponseHelper::error("Ocurrió un error inesperado. Por favor, contacte al soporte.");
        }
    }


    public function updateClient(array $data)
    {
        DB::beginTransaction();
        try {
            $client = $this->clientRepository->findById($data['id']);

            if (!$client) {
                return ResponseHelper::error("Cliente no encontrado.");
            }

            // Actualizar los datos del cliente
            $updated = $this->clientRepository->update($client, $data);

            if (!$updated) {
                return ResponseHelper::error("No se pudo actualizar el cliente.");
            }

            DB::commit();
            return ResponseHelper::success("Cliente actualizado correctamente.", ['client' => $client]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en updateClient: " . $e->getMessage());

            return ResponseHelper::error("Error al actualizar el cliente.");
        }
    }


    public function deleteClient(array $data)
    {
        DB::beginTransaction();
        try {
            $client = $this->clientRepository->findById($data['id']);

            if (!$client) {
                return ResponseHelper::error("Cliente no encontrado.");
            }

            // Intentar eliminar el cliente
            if (!$this->clientRepository->deleteClient($client)) {
                DB::rollBack();
                return ResponseHelper::error("No se pudo eliminar el cliente.");
            }

            DB::commit();
            return ResponseHelper::success("Cliente eliminado correctamente.");
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en deleteClient: " . $e->getMessage());

            return ResponseHelper::error("Error al eliminar el cliente.");
        }
    }


    public function profileClient(int $id)
    {
        try {
            // Obtener el cliente por su usuario
            $client = $this->clientRepository->getClientByUserId($id);

            if (!$client) {
                return ResponseHelper::error("Cliente no encontrado.");
            }

            // Obtener información adicional del cliente
            $data = [
                'dataUser' => $client,
                'communications' => $this->comunicationRepository->getLocationByCustomer($client->id),
                'lastAssignament' => $this->assignmentRepository->getLatestActiveAssignmentByCustomer($client->id),
                'lastCampaing' => $this->campaingRepository->getLastCampaignByCustomer($client->id),
                'campaings' => $this->campaingRepository->getCampaignsByCustomer($client->id),
                'lastProvider' => $this->providerRepository->getLastProviderByCustomer($client->id),
                'providers' => $this->providerRepository->getProvidersByCustomer($client->id),
                'priorities' => $this->priorityRepository->getActive(),
                'eventos' => $this->taskRepository->getEventsByCustomer($client->id),
                'vistas' => $this->viewsRepository->getViewsByClients($client->id),
            ];

            return ResponseHelper::success("Perfil del cliente obtenido correctamente.", $data);
        } catch (Exception $e) {
            Log::error("Error en profileClient: " . $e->getMessage());

            return ResponseHelper::error("Error al obtener el perfil del cliente.");
        }
    }


    public function searchCustomerByStatus(int $customerId)
    {
        try {
            $myRoles = $this->rolesService->getMyRoles();
            $userId = $this->userRepository->getMyUserId();
            $roles = $myRoles['roles'];

            // Obtener el agente si el usuario no es ADMINISTRADOR
            $agent = ($roles !== 'ADMINISTRADOR') ? $this->agentRepository->getByUserId($userId) : null;
            $agentId = $agent ? $agent->id : null;

            // Obtener clientes según el rol
            $customers = $this->clientRepository->getCustomersByStatusAndRole($customerId, $roles, $agentId);

            // Obtener datos adicionales
            $data = [
                'customers' => $customers,
                'agents' => $this->agentRepository->allActive(),
                'campaings' => $this->campaingRepository->getActiveCampaigns(),
                'providers' => $this->providerRepository->getAll(),
                'statusCustomers' => $this->clientRepository->getCustomerStatus(),
            ];

            return ResponseHelper::success("Clientes filtrados correctamente por estado.", $data);
        } catch (Exception $e) {
            Log::error("Error en searchCustomerByStatus: " . $e->getMessage());

            return ResponseHelper::error("Error al filtrar clientes por estado.");
        }
    }


    public function filterAdvanced(FilterRequest $request)
    {
        try {
            // Obtener los parámetros del request
            $filterFor = $request->filterFor ?? null;
            $inputName = $request->inputName ?? null;
            $statusId = $request->statusId ?? null;
            $typeRange = $request->typeRange ?? null;
            $dateInit = $request->dateInit ?? null;
            $dateEnd = $request->dateEnd ?? null;

            // Iniciar la consulta con relaciones necesarias
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
                'latestDeposit',
                'folder'
            ]);

            // Aplicar filtros dinámicos
            if (!empty($filterFor) && !empty($inputName)) {
                $filters = [
                    'Cod. Cliente' => ['code'],
                    'Nombre Cliente' => ['name', 'lastname'],
                    'Correo' => ['email'],
                    'Teléfono' => ['phone'],
                    'Teléfono Opcional' => ['optional_phone'],
                    'Ciudad' => ['city'],
                    'País' => ['country'],
                    'Comentario' => ['comment'],
                    'Proveedor' => ['provider' => 'name'],
                    'Folder' => ['folder' => 'name'],
                    'Asignado Por' => ['assignaments.assignedBy' => ['name', 'lastname']],
                    'Agente' => ['assignaments.agent' => ['name', 'lastname']],
                    'Última Visita' => ['views.agent' => ['name', 'lastname']],
                ];

                if (isset($filters[$filterFor])) {
                    foreach ($filters[$filterFor] as $relation => $fields) {
                        if (is_array($fields)) {
                            $query->whereHas($relation, function ($q) use ($fields, $inputName) {
                                foreach ($fields as $field) {
                                    $q->orWhere($field, 'like', "%$inputName%");
                                }
                            });
                        } else {
                            $query->where($fields, 'like', "%$inputName%");
                        }
                    }
                }
            }

            // Filtrar por estado si se proporciona
            if (!empty($statusId) && $statusId !== "Seleccione un estado") {
                $query->where('id_status', $statusId);
            }

            $assignament = new Assignment();
            $assignament->agent_id = $agent->id;
            $assignament->customer_id = $request->id;
            $assignament->date = Carbon::now();
            $assignament->assignated_by_id = $user_id;
            $assignament->status = 1;
            $assignament->save();

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
                        // ->orWhere('code', $request->dni_agent)
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
            $client->name = $request->name;
            $client->lastname = $request->lastname;
            $client->phone = $request->phone;
            $client->optional_phone = $request->optionalPhone;
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
        ];
 
        $communications = $this->communicationService->getLocationByCustomer($dataCommunication);
        $lastAssignament = $this->assignamentService->getLastAssignamentByCustomer($dataCommunication);
        $lastCampaing = $this->campaingService->getLastCampaingByCustomer($dataCommunication);
        $campaings = $this->campaingService->getAllCampaingsByCustomer($dataCommunication);
        $lastProvider = $this->providerService->getLastProviderByCustomer($dataCommunication);
        $providers = $this->providerService->getAllProvidersByCustomer($dataCommunication);
        $priorities = Priority::all();
<<<<<<< HEAD
        $listAssignaments = Assignment::with(['agent', 'customer', 'assignedBy'])->where('customer_id', $id)->orderBy('date', 'desc')->get();
        $eventos = Task::with(['customer', 'agent', 'priority'])->where('customer_id', $id)->orderBy('date', 'desc')->get();
        // Iteramos cada evento para asignar la fecha formateada
        $eventos->each(function ($evento) {
            $evento->formatted_date = $this->dateService->formatDate($evento->date);
        });
=======
        $eventos = Task::with('customer')->where('customer_id', $id)->get();
>>>>>>> feature/fix-presentation

        $vistas = Views::with('agent')
                        ->where('customer_id', $dataCustomer->id)
                        ->orderBy('viewed_at', 'desc')
                        ->get();

        return compact('rouletteSpin', 'dataUser', 'premios1', 'premios2', 'dataCustomer', 'communications', 'lastAssignament', 'lastCampaing', 'campaings', 'lastProvider', 'providers', 'priorities', 'eventos', 'vistas');

    }

}
