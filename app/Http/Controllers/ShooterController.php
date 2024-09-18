<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\CategoryFolder;
use App\Models\Comunications;
use App\Models\Customers;
use App\Models\Folder;
use App\Models\Premio;
use App\Models\Shooter;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShooterController extends Controller
{

    public function index()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        $roles = $user->getRoleNames()->first();
        $agent = Agent::where('user_id', $user_id)->first();
        $dataUser = $agent;
        $clients = [];


        $agent = Agent::where('user_id', $user_id)->first();
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $rouletteSpin = $agent->number_turns ?: 0;
        $clients = Customers::where('id_status', 1)->with(['latestComunication', 'latestCampaign', 'latestSupplier'])->get();

        $shooter = Shooter::where('status', 1)->first();

        if ($shooter) {
            $clients = Customers::where('folder_id', $shooter->folder_id)->where('status', true)->get();
        }

        $folders = Folder::where('status', 1)->get();

        return view('shooter.index', compact('premios1', 'premios2','rouletteSpin', 'dataUser', 'clients', 'shooter', 'folders'));
    }

    public function administrarShoter()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        $roles = $user->getRoleNames()->first();
        $agent = Agent::where('user_id', $user_id)->first();
        $dataUser = $agent;


        $agent = Agent::where('user_id', $user_id)->first();
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $rouletteSpin = $agent->number_turns ?: 0;

        $categoryFolders = CategoryFolder::where('status', 1)->get();
        $folders = Folder::where('status', 1)->where('category_id', 1)->get();

        return view('shooter.details.index', compact('premios1', 'premios2','rouletteSpin', 'dataUser', 'categoryFolders', 'folders'));
    }

    public function viewFolder(Request $request)
    {
        $folders = Folder::where('status', 1)->where('category_id', $request->categoryId)->get();
        return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render()]);
    }

    public function viewListClients(Request $request)
    {

        $clients = Customers::where('status', 1)->where('folder_id', $request->folderId)->get();
        // dd($clients);
        return response()->json(["view"=>view('shooter.components.listClient', compact('clients'))->render()]);
    }

    public function viewResumClient(Request $request)
    {
        $client = Customers::with(['latestComunication', 'latestAssignamet', 'statusCustomer', 'latestCampaign', 'latestSupplier', 'traiding'])->find($request->clientId);
        $comunications = Comunications::where('customer_id', $client->id)->get();
        // dd($comunications);
        return response()->json(["view"=>view('shooter.components.detailClient', compact('client', 'comunications'))->render()]);
    }

    public function activeShooter(Request $request)
    {
        $folder_id = $request->folder_id;
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $shooter_id = 0;
        $clients = [];

        try {
            $shooter = new Shooter();
            $shooter->status = true;
            $shooter->start = Carbon::now();
            $shooter->folder_id = $folder_id;
            if ($shooter->save()) {
                $title = "Éxito";
                $status = "success";
                $shooter_id = $shooter->id;
                $mensaje = "Shooter activado";
            }
        } catch (Exception $e) {
            $title = "Error";
            $status = "error";
            $mensaje = "Hubo un error en SHOOTER";
            echo("Error: " . $e->getMessage());
        }
        $shooter = Shooter::where('status', true)->first();
        if ($shooter) {
            $clients = Customers::where('folder_id', $shooter->folder_id)->where('status', true)->get();
        }
        return response()->json(["view"=>view('shooter.components.btnActiveAdmin', compact('shooter'))->render(), "viewClients"=>view('shooter.table.tableShooter', compact('clients', 'shooter'))->render(), "shooter_id" => $shooter_id, "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function disableShooter(Request $request)
    {
        $shooter_id = $request->shooter_id;
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $clients = [];

        try {
            $shooter = Shooter::find($shooter_id);
            $shooter->end = Carbon::now();
            $shooter->status = false;
            if ($shooter->save()) {
                $title = "Éxito";
                $status = "success";
                $mensaje = "Shooter apagado";
            }
        } catch (Exception $e) {
            $title = "Error";
            $status = "error";
            $mensaje = "Hubo un error en SHOOTER";
            echo("Error: " . $e->getMessage());
        }
        $shooter = Shooter::where('status', true)->first();
        if ($shooter) {
            $clients = Customers::where('folder_id', $shooter->folder_id)->where('status', true)->get();
        }
        return response()->json(["view"=>view('shooter.components.btnActiveAdmin', compact('shooter'))->render(), "viewClients"=>view('shooter.table.tableShooter', compact('clients', 'shooter'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }
}
