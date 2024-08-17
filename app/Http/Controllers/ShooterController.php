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


        $agent = Agent::where('user_id', $user_id)->first();
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $rouletteSpin = $agent->number_turns ?: 0;
        $clients = Customers::where('id_status', 1)->with(['latestComunication', 'latestCampaign', 'latestSupplier'])->get();

        $shooter = Shooter::where('status', 1)->with('folder')->first();
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

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
