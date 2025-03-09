<?php
namespace App\Services;

use App\Enums\StatusEnum;
use App\Helpers\ResponseHelper;
use App\Http\Requests\FolderRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\CampaingRepositoryInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\ClientStatusRepositoryInterface;
use App\Interfaces\FolderRepositoryInterface;
use App\Interfaces\ProviderRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Customers;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class FolderService
{

    protected $folderRepository, $rolesService, $userRepository, $clientRepository, $agentRepository, $campaingRepository, $providerRepository, $statusCustomerRepository;

    public function __construct(
        FolderRepositoryInterface $folderRepository,
        RolesService $rolesService,
        UserRepositoryInterface $userRepository,
        ClientRepositoryInterface $clientRepository,
        AgentRepositoryInterface $agentRepository,
        CampaingRepositoryInterface $campaingRepository,
        ProviderRepositoryInterface $providerRepository,
        ClientStatusRepositoryInterface $statusCustomerRepository
    ) {
      $this->folderRepository = $folderRepository;  
      $this->rolesService = $rolesService;
      $this->userRepository = $userRepository;
      $this->clientRepository = $clientRepository;
      $this->agentRepository = $agentRepository;
      $this->campaingRepository = $campaingRepository;
      $this->providerRepository = $providerRepository;
      $this->statusCustomerRepository = $statusCustomerRepository;
    }

    public function deleteFolder(FolderRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $this->folderRepository->disableFolder($request->folderId);
            $folders = $this->folderRepository->getFoldersByCategory(1);
            DB::commit();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $folders]);
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

    public function addGroupClientFolder(FolderRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $this->folderRepository->assignClientToFolder($request->folderId, $request->idGroupClientes);
            DB::commit();
            $relations = [
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
            ];
            $customers = $this->clientRepository->getAllClients($request->limit, $relations);
            $agents = $this->agentRepository->getAgents();
            $campaings = $this->campaingRepository->getCampaing();
            $providers = $this->providerRepository->getProviders();
            $statusCustomers = $this->statusCustomerRepository->getCustomerStatus();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $customers]);
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

    public function saveFolder(StoreFolderRequest $request)
    {
        DB::beginTransaction();
        try {
            $dataFolders = new StoreFolderRequest([
                'name' => $request->name,
                'status' => StatusEnum::ACTIVE->value,
                'category_id' => $request->categoryId
            ]);
            $response = $this->folderRepository->saveFolder($request);
            DB::commit();
            $folders = $this->folderRepository->getFoldersByCategory(1);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $folders]);
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

    public function addClientFolder($request)
    {
        try {
        $customer = $this->clientRepository->getClientByCode($request->codeClient);
        $dataChangeFolder = new StoreCustomerRequest([
            'folder_id' => $request->folderId
        ]);
        $data = $this->clientRepository->changeFolderClient($customer, $dataChangeFolder);
        $clients = Customers::where('status', 1)->where('folder_id', $request->folderId)->get();
        return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $clients]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function moveFolder($request)
    {
        try {
            $folder = $this->folderRepository->findFolderById($request->folderId);
            $dataFolder = new StoreFolderRequest([
                'category_id' => $request->categoryId
            ]);
            $response = $this->folderRepository->changeFolderCategory($folder->id, $dataFolder);
            $folders = $this->folderRepository->getFolders();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $folders]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function editFolder($request)
    {
        try {
            $folder = $this->folderRepository->findFolderById($request->folderId);
            $dataFolder = new StoreFolderRequest([
                'name' => $request->name,
                'category_id' => $folder->category_id
            ]);
            $response = $this->folderRepository->updateFolder($folder, $dataFolder);
            $folders = $this->folderRepository->getFolders();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $folders]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function changeFolderClient($request)
    {
        // $title = 'Error';
        // $mensaje = 'Error desconocido';
        // $status = 'error';

        // try {

        //     $customer = Customers::find($request->clienteId);

        //     $customer->folder_id = $request->folderId;

        //     if ($customer->save()) {
        //         $title = "Correcto";
        //         $mensaje = "Cliente asignado correctamente";
        //         $status = "success";
        //     }

        // } catch (Exception $e) {
        //     $title = 'Error';
        //     $mensaje = 'Ocurrió un error: '.$e->getMessage();
        //     $status = 'error';
        // }

        // $myRoles = $this->rolesService->getMyRoles();
        // $myRolesId = $myRoles['rolesId'];
        // $user_id = Auth::user()->id;
        // $agent = Agent::where('user_id', $user_id)->first();

        // if ($myRoles['roles']== 'ADMINISTRADOR') {

        //     $customers = Customers::with([
        //         'user',
        //         'agent',
        //         'latestCampaign',
        //         'latestSupplier',
        //         'provider',
        //         'statusCustomer',
        //         'platform',
        //         'traiding',
        //         'latestComunication',
        //         'latestAssignamet',
        //         'latestDeposit'
        //     ])->orderBy('date_admission', 'desc')->paginate(10);

        // } else {

        //     $customers = Customers::with([
        //         'user',
        //         'agent',
        //         'latestCampaign',
        //         'latestSupplier',
        //         'provider',
        //         'statusCustomer',
        //         'platform',
        //         'traiding',
        //         'assignaments',
        //         'latestComunication',
        //         'latestAssignamet',
        //         'latestDeposit'
        //     ])->whereHas('assignaments', function($query) use ($agent) {
        //         $query->where('agent_id', $agent->id);
        //     })->orderBy('date_admission', 'desc')->paginate(10);
        // }

        // $agents = Agent::all();
        // $campaings = Campaing::all();
        // $providers = Provider::all();
        // $statusCustomers = CustomerStatus::all();

        // return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }


} 