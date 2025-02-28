<?php
namespace App\Services;

use Illuminate\Http\Request;

class ShooterService
{

    protected $shooterRepository;

    public function __construct(
        ShooterRepositoryInterface $shooterRepository
    ) {
      $this->shooterRepository = $shooterRepository;  
    }

    public function getShooterData()
    {
        // $user_id = Auth::user()->id;
        // $user = User::where('id', $user_id)->first();
        // $roles = $user->getRoleNames()->first();
        // $agent = Agent::where('user_id', $user_id)->first();
        // $dataUser = $agent;
        // $clients = [];

        // // $user = User::find($user_id); // Usuario al que enviarás la notificación
        // // $user->notify(new InitNotification(['message' => '¡Notificación en tiempo real  SEND!']));


        // $agent = Agent::where('user_id', $user_id)->first();
        // $premios1 = Premio::where('status', true)->where('type', 1)->get();
        // $premios2 = Premio::where('status', true)->where('type', 2)->get();
        // $rouletteSpin = $agent->number_turns ?: 0;
        // $clients = Customers::where('id_status', 1)->with(['latestComunication', 'latestCampaign', 'latestSupplier'])->get();

        // $shooter = Shooter::where('status', 1)->first();
        // $na = CustomerStatus::where('name', 'NA')->first();
        // $na_1 = CustomerStatus::where('name', 'NA 1')->first();
        // $na_2 = CustomerStatus::where('name', 'NA 2')->first();
        // $na_3 = CustomerStatus::where('name', 'NA 3')->first();

        // //dd($na_1);

        // if ($shooter) {
        //     $clients = Customers::where('folder_id', $shooter->folder_id)->whereNotIn('id_status', [$na->id, $na_1->id, $na_2->id, $na_3->id])->get();
        // }

        // $folders = Folder::where('status', 1)->get();
        // $statusCustomers = CustomerStatus::all();

        // return view('shooter.index', compact('premios1', 'premios2','rouletteSpin', 'dataUser', 'clients', 'shooter', 'folders', 'statusCustomers'));
    }

    public function getShooterAdmin()
    {
        // $user_id = Auth::user()->id;
        // $user = User::where('id', $user_id)->first();
        // $roles = $user->getRoleNames()->first();
        // $agent = Agent::where('user_id', $user_id)->first();
        // $dataUser = $agent;


        // $agent = Agent::where('user_id', $user_id)->first();
        // $premios1 = Premio::where('status', true)->where('type', 1)->get();
        // $premios2 = Premio::where('status', true)->where('type', 2)->get();
        // $rouletteSpin = $agent->number_turns ?: 0;

        // $categoryFolders = CategoryFolder::where('status', 1)->get();
        // $folders = Folder::where('status', 1)->where('category_id', 1)->get();

        // return view('shooter.details.index', compact('premios1', 'premios2','rouletteSpin', 'dataUser', 'categoryFolders', 'folders'));
    }

    public function getFolderData()
    {
        // $folders = Folder::where('status', 1)->where('category_id', $request->categoryId)->get();
        // return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render()]);
    }

    public function getClientsByFolder(Request $request)
    {
        // $clients = Customers::where('status', 1)->where('folder_id', $request->folderId)->get();
        // return response()->json(["view"=>view('shooter.components.listClient', compact('clients'))->render()]);
    }

    public function getResumClient(Request $request)
    {
        // $client = Customers::with(['latestComunication', 'latestAssignamet', 'statusCustomer', 'latestCampaign', 'latestSupplier', 'traiding'])->find($request->clientId);
        // $comunications = Comunications::where('customer_id', $client->id)->get();
        // return response()->json(["view"=>view('shooter.components.detailClient', compact('client', 'comunications'))->render()]);
    }

    public function activeShooter(Request $request)
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

    public function disableShooter(Request $request)
    {
        // $shooter_id = $request->shooter_id;
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";
        // $clients = [];

        // try {
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

    public function notiffyShooter()
    {
        // $type = "";
        // $message = "";
        // $shooter = "0";
        // $phone = "";

        // $user_id = Auth::user()->id;
        // $agent = Agent::where('user_id', $user_id)->first();

        // $shooter = Shooter::where('status', 1)->first();

        // if ($shooter) {
        //     $clients = Customers::where('folder_id', $shooter->folder_id)->get();

        //     if ($clients->isNotEmpty()) {
        //         $randomClient = $clients->random();
        //         $message = "Llamada activa con " . $randomClient->name;
        //         $phone = $randomClient->phone;
        //         $type = "info";
        //         $shooter = "1";
        //     }

        // }

        // return response()->json(["type" => $type, "message" => $message, "shooter" => $shooter, "phone" => $phone]);
    }

}