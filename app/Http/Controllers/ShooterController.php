<?php

namespace App\Http\Controllers;

// use App\Events\RealTimeNotification;
use App\Http\Controllers\Controller;
use App\Imports\CustomersByFolderImport;
use App\Models\Agent;
use App\Models\CategoryFolder;
use App\Models\Comunications;
use App\Models\Customers;
use App\Models\CustomerStatus;
use App\Models\Folder;
use App\Models\Premio;
use App\Models\Shooter;
use App\Models\User;
use App\Services\ShooterService;
// use App\Notifications\InitNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ShooterController extends Controller
{

    protected $shooterService;

    public function __construct(ShooterService $shooterService) {
        $this->shooterService = $shooterService;
    }

    public function index()
    {
        try {
            $data = $this->shooterService->getShooterData();
            $rouletteSpin = $data->rouletteSpin;
            $clients = $data->clients;
            $shooter = $data->shooter;
            $folders = $data->folders;
            $statusCustomers = $data->statusCustomers;
            return view('shooter.index', compact('rouletteSpin', 'dataUser', 'clients', 'shooter', 'folders', 'statusCustomers'));
        } catch (Exception $e) {
            Log::error("Error en ShooterController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar los datos de shooter.');
        }
    }

    public function administrarShoter()
    {
        try {
            $data = $this->shooterService->getShooterAdmin();
            $rouletteSpin = $data->rouletteSpin;
            $categoryFolders = $data->categoryFolders;
            $folders = $data->folders;
            return view('shooter.admin.index', compact('rouletteSpin', 'dataUser', 'categoryFolders', 'folders'));
        } catch (Exception $e) {
            Log::error("Error en ShooterController: " . $e->getMessage());
        }
    }

    public function viewFolder(Request $request)
    {
        try {
            $data = $this->shooterService->getFolderData($request);
            $folders = $data->folders;
            return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render()]);
        } catch (Exception $e) {
            Log::error("Error en ShooterController: " . $e->getMessage());
        }
    }

    public function viewListClients(Request $request)
    {
        try {
            $data = $this->shooterService->getClientsByFolder($request);
            $clients = $data->clients;
            return response()->json(["view"=>view('shooter.components.listClient', compact('clients'))->render()]);
        } catch (Exception $e) {
            Log::error("Error en ShooterController: " . $e->getMessage());
        }
    }

    public function viewResumClient(Request $request)
    {
        try {
            $data = $this->shooterService->getResumClient($request);
            $client = $data->client;
            $comunications = $data->comunications;
            return response()->json(["view"=>view('shooter.components.detailClient', compact('client', 'comunications'))->render()]);
        } catch (Exception $e) {
            Log::error("Error en ShooterController: " . $e->getMessage());
        }
    }

    public function activeShooter(Request $request)
    {
        try {
            $data = $this->shooterService->activeShooter($request);
            $shooter = $data->shooter;
            $dataClients = $this->shooterService->getClientsByFolder($request);
            $clients = $dataClients->clients;
            return response()->json(["view"=>view('shooter.components.btnActiveAdmin', compact('shooter'))->render(), "viewClients"=>view('shooter.table.tableShooter', compact('clients', 'shooter'))->render(), "shooter_id" => $shooter->id, "title" => 'Éxito', "text" => 'Shooter activado', "status" => 'success']);
        } catch (Exception $e) {
            Log::error("Error en ShooterController: " . $e->getMessage());
        }
        
        // if ($shooter) {
        //     $clients = Customers::where('folder_id', $shooter->folder_id)->whereNotIn('id_status', [$na->id, $na_1->id, $na_2->id, $na_3->id])->get();
        // }
        // return response()->json(["view"=>view('shooter.components.btnActiveAdmin', compact('shooter'))->render(), "viewClients"=>view('shooter.table.tableShooter', compact('clients', 'shooter'))->render(), "shooter_id" => $shooter_id, "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function disableShooter(Request $request)
    {
        try {
            $data = $this->shooterService->disableShooter($request);
            $shooter = $data->shooter;
            $dataClients = $this->shooterService->getClientsByFolder($request);
            $clients = $dataClients->clients;
            return response()->json(["view"=>view('shooter.components.btnActiveAdmin', compact('shooter'))->render(), "viewClients"=>view('shooter.table.tableShooter', compact('clients', 'shooter'))->render(), "title" => 'Éxito', "text" => 'Shooter apagado', "status" => 'success']);
        } catch (Exception $e) {
            Log::error("Error en ShooterController: " . $e->getMessage());
        }
        
        // if ($shooter) {
        //     $clients = Customers::where('folder_id', $shooter->folder_id)->whereNotIn('id_status', [$na->id, $na_1->id, $na_2->id, $na_3->id])->get();
        // }
        // return response()->json(["view"=>view('shooter.components.btnActiveAdmin', compact('shooter'))->render(), "viewClients"=>view('shooter.table.tableShooter', compact('clients', 'shooter'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function uploadExcelByFolder(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(["title" => 'Error', "text" => 'No file uploaded', "status" => 'error']);
        }

        $file = $request->file('file');
        $folder_id = $request->folder_id;

        if (!$file->isValid()) {
            return response()->json(["title" => 'Error', "text" => 'Invalid file upload', "status" => 'error']);
        }

        try {
            Excel::import(new CustomersByFolderImport($folder_id), $file);
            $clients = Customers::where('status', 1)->where('folder_id', $request->folderId)->get();
            return response()->json(["view"=>view('shooter.components.listClient', compact('clients'))->render(), "title" => 'Correcto', "text" => 'Clientes agregados', "status" => 'success']);
        } catch (Exception $e) {
            return response()->json(["title" => 'Error', "text" => 'Failed to upload file: '.$e->getMessage(), "status" => 'error']);
        }

    }

    public function notiffyShooter() {
        try {
            $data = $this->shooterService->notiffyShooter();
            $shooter = $data->shooter;
            $type = $data->type;
            $message = $data->message;
            $phone = $data->phone;
            return response()->json(["type" => $type, "message" => $message, "shooter" => $shooter, "phone" => $phone]);
        } catch (Exception $e) {
            Log::error("Error en ShooterController: " . $e->getMessage());
        }
    }
}
