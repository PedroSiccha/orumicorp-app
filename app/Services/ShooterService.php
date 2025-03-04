<?php
namespace App\Services;

use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\CategoryFolderRepositoryInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\ClientStatusRepositoryInterface;
use App\Interfaces\ComunicationRepositoryInterface;
use App\Interfaces\FolderRepositoryInterface;
use App\Interfaces\ShooterRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class ShooterService
{

    protected $shooterRepository, $userRepository, $agentRepository, $clientRepository, $clientStatusRepository, $folderRepository, $categoryFolderRepository, $comunicationRepository;

    public function __construct(
        ShooterRepositoryInterface $shooterRepository,
        UserRepositoryInterface $userRepository,
        AgentRepositoryInterface $agentRepository,
        ClientRepositoryInterface $clientRepository,
        ClientStatusRepositoryInterface $clientStatusRepository,
        FolderRepositoryInterface $folderRepository,
        CategoryFolderRepositoryInterface $categoryFolderRepository,
        ComunicationRepositoryInterface $comunicationRepository
    ) {
      $this->shooterRepository = $shooterRepository;  
      $this->userRepository = $userRepository;  
      $this->agentRepository = $agentRepository;  
      $this->clientRepository = $clientRepository;  
      $this->clientStatusRepository = $clientStatusRepository;  
      $this->folderRepository = $folderRepository;  
      $this->categoryFolderRepository = $categoryFolderRepository;  
      $this->comunicationRepository = $comunicationRepository;  
    }

    public function getShooterData()
    {
        // $user_id = Auth::user()->id;
        $user = $this->userRepository->findUser(); // User::where('id', $user_id)->first();
        $roles = $user->getRoleNames()->first();
        $agent = $this->agentRepository->getAgentByUserId($user->id); // Agent::where('user_id', $user_id)->first();
        // $dataUser = $agent;
        // $clients = [];

        // // $user = User::find($user_id); // Usuario al que enviarás la notificación
        // // $user->notify(new InitNotification(['message' => '¡Notificación en tiempo real  SEND!']));


        // $agent = Agent::where('user_id', $user_id)->first();
        // $premios1 = Premio::where('status', true)->where('type', 1)->get();
        // $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $rouletteSpin = $agent->number_turns ?: 0;
        $clients = $this->clientRepository->getClientsByStatus(1);

        $shooter = $this->shooterRepository->getShooter();
        $na = $this->clientStatusRepository->findStatusByName('NA'); 
        $na_1 = $this->clientStatusRepository->findStatusByName('NA 1');
        $na_2 = $this->clientStatusRepository->findStatusByName('NA 2');
        $na_3 = $this->clientStatusRepository->findStatusByName('NA 3');

        // //dd($na_1);

        if ($shooter) {
            $clients = $this->clientRepository->getClientsByFolderExceptStatus($shooter->folder_id, [$na->id, $na_1->id, $na_2->id, $na_3->id]);
        }

        $folders = $this->folderRepository->getFolders(); // Folder::where('status', 1)->get();
        $statusCustomers = $this->clientStatusRepository->getStatus();

        // return view('shooter.index', compact('premios1', 'premios2','rouletteSpin', 'dataUser', 'clients', 'shooter', 'folders', 'statusCustomers'));
    }

    public function getShooterAdmin()
    {
        // $user_id = Auth::user()->id;
        // $user = User::where('id', $user_id)->first();
        $user = $this->userRepository->findUser();
        $roles = $user->getRoleNames()->first();
        $agent = $this->agentRepository->getAgentByUserId($user->id);// $agent = Agent::where('user_id', $user_id)->first();
        // $dataUser = $agent;


        // $agent = Agent::where('user_id', $user_id)->first();
        // $premios1 = Premio::where('status', true)->where('type', 1)->get();
        // $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $rouletteSpin = $agent->number_turns ?: 0;

        $categoryFolders = $this->categoryFolderRepository->getCategoryFolders(); // CategoryFolder::where('status', 1)->get();
        $folders = $this->folderRepository->getFoldersByCategory(1);

        // return view('shooter.details.index', compact('premios1', 'premios2','rouletteSpin', 'dataUser', 'categoryFolders', 'folders'));
    }

    public function getFolderData(int $categoryId)
    {
        $folders = $this->folderRepository->getFoldersByCategory($categoryId);
        // return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render()]);
    }

    public function getClientsByFolder(int $folderId)
    {
        $clients = $this->clientRepository->getClientsByFolder($folderId);
        // return response()->json(["view"=>view('shooter.components.listClient', compact('clients'))->render()]);
    }

    public function getResumClient(int $clientId)
    {
        // $client = $this->clientRepository->getClientById($request->clientId); // Customers::with(['latestComunication', 'latestAssignamet', 'statusCustomer', 'latestCampaign', 'latestSupplier', 'traiding'])->find($request->clientId);
        $comunications = $this->comunicationRepository->getComunicationsByClient($clientId);
        // return response()->json(["view"=>view('shooter.components.detailClient', compact('client', 'comunications'))->render()]);
    }

    public function activeShooter(StoreShooterRequest $request)
    {
        // $folder_id = $request->folder_id;
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";
        // $shooter_id = 0;
        // $clients = [];

        // try {
        //     $message = "Este es un mensaje de notificación en tiempo real!";
        //     // broadcast(new RealTimeNotification($message));
        // } catch (Exception $e) {
        // }

        $response = $this->shooterRepository->saveShooter($request);

        // try {
        //     $shooter = new Shooter();
        //     $shooter->status = true;
        //     $shooter->start = Carbon::now();
        //     $shooter->folder_id = $folder_id;
        //     if ($shooter->save()) {
        //         $title = "Éxito";
        //         $status = "success";
        //         $shooter_id = $shooter->id;
        //         $mensaje = "Shooter activado";
        //     }
        // } catch (Exception $e) {
        //     $title = "Error";
        //     $status = "error";
        //     $mensaje = "Hubo un error en SHOOTER";
        //     echo("Error: " . $e->getMessage());
        // }
        // $shooter = Shooter::where('status', true)->first();
        // $na = CustomerStatus::where('name', 'NA')->first();
        // $na_1 = CustomerStatus::where('name', 'NA 1')->first();
        // $na_2 = CustomerStatus::where('name', 'NA 2')->first();
        // $na_3 = CustomerStatus::where('name', 'NA 3')->first();
    }

    public function disableShooter(int $shooterId)
    {
        // $shooter_id = $request->shooter_id;
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";
        // $clients = [];

        // try {
        $response = $this->shooterRepository->disableShooter($shooterId);
        //     $shooter = Shooter::find($shooter_id);
        //     $shooter->end = Carbon::now();
        //     $shooter->status = false;
        //     if ($shooter->save()) {
        //         $title = "Éxito";
        //         $status = "success";
        //         $mensaje = "Shooter apagado";
        //     }
        // } catch (Exception $e) {
        //     $title = "Error";
        //     $status = "error";
        //     $mensaje = "Hubo un error en SHOOTER";
        //     echo("Error: " . $e->getMessage());
        // }
        // $shooter = Shooter::where('status', true)->first();
        // $na = CustomerStatus::where('name', 'NA')->first();
        // $na_1 = CustomerStatus::where('name', 'NA 1')->first();
        // $na_2 = CustomerStatus::where('name', 'NA 2')->first();
        // $na_3 = CustomerStatus::where('name', 'NA 3')->first();
    }

    public function notiffyShooter(Request $request)
    {
        // $type = "";
        // $message = "";
        // $shooter = "0";
        // $phone = "";

        // $user_id = Auth::user()->id;
        // $agent = Agent::where('user_id', $user_id)->first();
        $user = $this->userRepository->findUser();
        $agent = $this->agentRepository->getAgentByUserId($user->id);
        $shooter = $this->shooterRepository->getShooter();

        // $shooter = Shooter::where('status', 1)->first();

        if ($shooter) {
            $clients = $this->clientRepository->getClientsByFolder($request->folderId);

        //     if ($clients->isNotEmpty()) {
        //         $randomClient = $clients->random();
        //         $message = "Llamada activa con " . $randomClient->name;
        //         $phone = $randomClient->phone;
        //         $type = "info";
        //         $shooter = "1";
        //     }

        }

        // return response()->json(["type" => $type, "message" => $message, "shooter" => $shooter, "phone" => $phone]);
    }

}