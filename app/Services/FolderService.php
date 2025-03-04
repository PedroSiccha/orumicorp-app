<?php
namespace App\Services;

use App\Http\Requests\FolderRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Interfaces\FolderRepositoryInterface;

class FolderService
{

    protected $folderRepository, $rolesService, $userRepository, $clientRepository, $agentRepository, $campaingRepository, $providerRepository, $statusCustomerRepository;

    public function __construct(
        FolderRepositoryInterface $folderRepository,
        RolesService $rolesService
    ) {
      $this->folderRepository = $folderRepository;  
      $this->rolesService = $rolesService;
    }

    public function deleteFolder(FolderRequest $request)
    {
        // $title = 'Error';
        // $mensaje = 'Error desconocido';
        // $status = 'error';

        // try {
        // $folder = $this->folderRepository->findFolderById($request->id);
        $data = $this->folderRepository->disableFolder($request->id);
        

        //     $title = "Correcto";
        //     $mensaje = "Actualización correcta";
        //     $status = "success";

        // } catch (Exception $e) {
        //     $title = 'Error';
        //     $mensaje = 'Ocurrió un error: '.$e->getMessage();
        //     $status = 'error';
        // }
        $folders = $this->folderRepository->getFoldersByCategory(1);
        
        // return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function addGroupClientFolder(FolderRequest $request)
    {
        // $title = 'Error';
        // $mensaje = 'Error desconocido';
        // $status = 'error';

        // try {
        $data = $this->folderRepository->assignClientToFolder($request->folderId, $request->idGroupClientes);

        // } catch (Exception $e) {
        //     $title = "Error";
        //     $mensaje = "Ocurrió un error: " . $e->getMessage();
        //     $status = "error";
        // }

        $myRoles = $this->rolesService->getMyRoles();
        $myRolesId = $myRoles['rolesId'];
        // $user_id = Auth::user()->id;
        $user_id = $this->userRepository->getMyId();
        $agent = $this->agentRepository->getAgentByUserId();
        // $agent = Agent::where('user_id', $user_id)->first();
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
        $agents = $this->agentRepository->getAgents();
        // $agents = Agent::all();
        $campaings = $this->campaingRepository->getCampaing();
        // $campaings = Campaing::all();
        $providers = $this->providerRepository->getProviders();
        // $providers = Provider::all();
        $statusCustomers = $this->statusCustomerRepository->getStatusCustomer();
        // $statusCustomers = CustomerStatus::all();

        // return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function saveFolder(StoreFolderRequest $request)
    {
        // $title = 'Error';
        // $mensaje = 'Error desconocido';
        // $status = 'error';

        // try {
        $folder = $this->folderRepository->saveFolder($request);
        //     $folder = new Folder();
        //     $folder->status = true;
        //     $folder->name = $request->name;
        //     $folder->category_id = $request->categoryId;
        //     $folder->save();

        //     $title = "Correcto";
        //     $mensaje = "Folder creado correctamente";
        //     $status = "success";

        // } catch (Exception $e) {
        //     $title = 'Error';
        //     $mensaje = 'Ocurrió un error: '.$e->getMessage();
        //     $status = 'error';
        // }
        
        $folders = $this->folderRepository->getFoldersByCategory(1);
        // return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function addClientFolder(FolderRequest $request)
    {
        // $title = 'Error';
        // $mensaje = 'Error desconocido';
        // $status = 'error';

        // try {
        $customer = $this->clientRepository->getClientByCode($request->codeClient);
        $data = $this->clientRepository->changeFolderClient($request->folderId);

        //     $customer = Customers::where('code', $request->codeClient)
        //                             ->first();

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

        // $clients = Customers::where('status', 1)->where('folder_id', $request->folderId)->get();

        // return response()->json(["view"=>view('shooter.components.listClient', compact('clients'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function moveFolder(FolderRequest $request)
    {
        // $title = 'Error';
        // $mensaje = 'Error desconocido';
        // $status = 'error';

        // try {
        //     $folder = Folder::find($request->folderId);
        //     $folder->category_id = $request->categoryId;
        //     if ($folder->save()) {
        //         $title = "Correcto";
        //         $mensaje = "Folder movido correctamente";
        //         $status = "success";
        //     }
        // } catch (Exception $e) {
        //     $title = 'Error';
        //     $mensaje = 'Ocurrió un error: '.$e->getMessage();
        //     $status = 'error';
        // }

        // $folders = Folder::where('status', 1)->where('category_id', 1)->get();
        // return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function editFolder(FolderRequest $request)
    {
        // $title = 'Error';
        // $mensaje = 'Error desconocido';
        // $status = 'error';
        // $idCategory = 0;

        // try {
        //     $folder = Folder::find($request->folderId);
        //     $idCategory = $folder->category_id;
        //     $folder->name = $request->name;
        //     if ($folder->save()) {
        //         $title = "Correcto";
        //         $mensaje = "Nombre cambiado";
        //         $status = "success";
        //     }
        // } catch (Exception $e) {
        //     $title = 'Error';
        //     $mensaje = 'Ocurrió un error: '.$e->getMessage();
        //     $status = 'error';
        // }

        // $folders = Folder::where('status', 1)->where('category_id', $idCategory)->get();
        // return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function changeFolderClient(FolderRequest $request)
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