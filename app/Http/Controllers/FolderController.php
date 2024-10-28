<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Http\Controllers\Controller;
use App\Interfaces\RolesInterface;
use App\Models\Agent;
use App\Models\Campaing;
use App\Models\Customers;
use App\Models\CustomerStatus;
use App\Models\Provider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{

    protected $rolesService;

    public function __construct(
        RolesInterface $rolesService,
    ) {
        $this->rolesService = $rolesService;
    }

    public function deleteFolder(Request $request)
    {
        $title = 'Error';
        $mensaje = 'Error desconocido';
        $status = 'error';

        try {
            $folder = Folder::find($request->id);
            $folder->status = false;
            $folder->save();

            $title = "Correcto";
            $mensaje = "Actualización correcta";
            $status = "success";

        } catch (Exception $e) {
            $title = 'Error';
            $mensaje = 'Ocurrió un error: '.$e->getMessage();
            $status = 'error';
        }
        $folders = Folder::where('status', 1)->where('category_id', 1)->get();
        return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);

    }

    public function addGroupClientFolder(Request $request)
    {
        $title = 'Error';
        $mensaje = 'Error desconocido';
        $status = 'error';

        try {

            foreach ($request->idGroupClientes as $idClient) {

                $client = Customers::find($idClient);
                $client->folder_id = $request->folderId;
                $client->save();

                $title = "Correcto";
                $mensaje = "Actualización correcta";
                $status = "success";

            }

        } catch (Exception $e) {
            $title = "Error";
            $mensaje = "Ocurrió un error: " . $e->getMessage();
            $status = "error";
        }

        $myRoles = $this->rolesService->getMyRoles();
        $myRolesId = $myRoles['rolesId'];
        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();

        if ($myRoles['roles']== 'ADMINISTRADOR') {

            $customers = Customers::with([
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
            ])->orderBy('date_admission', 'desc')->paginate(10);

        } else {

            $customers = Customers::with([
                'user',
                'agent',
                'latestCampaign',
                'latestSupplier',
                'provider',
                'statusCustomer',
                'platform',
                'traiding',
                'assignaments',
                'latestComunication',
                'latestAssignamet',
                'latestDeposit'
            ])->whereHas('assignaments', function($query) use ($agent) {
                $query->where('agent_id', $agent->id);
            })->orderBy('date_admission', 'desc')->paginate(10);
        }

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);

    }

    public function saveFolder(Request $request)
    {
        $title = 'Error';
        $mensaje = 'Error desconocido';
        $status = 'error';

        try {
            $folder = new Folder();
            $folder->status = true;
            $folder->name = $request->name;
            $folder->category_id = $request->categoryId;
            $folder->save();

            $title = "Correcto";
            $mensaje = "Folder creado correctamente";
            $status = "success";

        } catch (Exception $e) {
            $title = 'Error';
            $mensaje = 'Ocurrió un error: '.$e->getMessage();
            $status = 'error';
        }
        $folders = Folder::where('status', 1)->where('category_id', 1)->get();
        return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function addClientFolder(Request $request)
    {
        $title = 'Error';
        $mensaje = 'Error desconocido';
        $status = 'error';

        try {

            $customer = Customers::where('code', $request->codeClient)
                                    ->first();

            $customer->folder_id = $request->folderId;
            if ($customer->save()) {
                $title = "Correcto";
                $mensaje = "Cliente asignado correctamente";
                $status = "success";
            }

        } catch (Exception $e) {
            $title = 'Error';
            $mensaje = 'Ocurrió un error: '.$e->getMessage();
            $status = 'error';
        }

        // $folders = Folder::where('status', 1)->where('category_id', 1)->get();
        $clients = Customers::where('status', 1)->where('folder_id', $request->folderId)->get();
        // return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
        return response()->json(["view"=>view('shooter.components.listClient', compact('clients'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);

    }

    public function moveFolder(Request $request)
    {
        $title = 'Error';
        $mensaje = 'Error desconocido';
        $status = 'error';

        try {
            $folder = Folder::find($request->folderId);
            $folder->category_id = $request->categoryId;
            if ($folder->save()) {
                $title = "Correcto";
                $mensaje = "Folder movido correctamente";
                $status = "success";
            }
        } catch (Exception $e) {
            $title = 'Error';
            $mensaje = 'Ocurrió un error: '.$e->getMessage();
            $status = 'error';
        }

        $folders = Folder::where('status', 1)->where('category_id', 1)->get();
        return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function editFolder(Request $request)
    {
        $title = 'Error';
        $mensaje = 'Error desconocido';
        $status = 'error';
        $idCategory = 0;

        try {
            $folder = Folder::find($request->folderId);
            $idCategory = $folder->category_id;
            $folder->name = $request->name;
            if ($folder->save()) {
                $title = "Correcto";
                $mensaje = "Nombre cambiado";
                $status = "success";
            }
        } catch (Exception $e) {
            $title = 'Error';
            $mensaje = 'Ocurrió un error: '.$e->getMessage();
            $status = 'error';
        }

        $folders = Folder::where('status', 1)->where('category_id', $idCategory)->get();
        return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function changeFolderClient(Request $request)
    {
        $title = 'Error';
        $mensaje = 'Error desconocido';
        $status = 'error';

        //dd($request);

        try {

            $customer = Customers::find($request->clienteId);

            $customer->folder_id = $request->folderId;

            if ($customer->save()) {
                $title = "Correcto";
                $mensaje = "Cliente asignado correctamente";
                $status = "success";
            }

        } catch (Exception $e) {
            $title = 'Error';
            $mensaje = 'Ocurrió un error: '.$e->getMessage();
            $status = 'error';
        }

        $myRoles = $this->rolesService->getMyRoles();
        $myRolesId = $myRoles['rolesId'];
        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();

        if ($myRoles['roles']== 'ADMINISTRADOR') {

            $customers = Customers::with([
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
            ])->orderBy('date_admission', 'desc')->paginate(10);

        } else {

            $customers = Customers::with([
                'user',
                'agent',
                'latestCampaign',
                'latestSupplier',
                'provider',
                'statusCustomer',
                'platform',
                'traiding',
                'assignaments',
                'latestComunication',
                'latestAssignamet',
                'latestDeposit'
            ])->whereHas('assignaments', function($query) use ($agent) {
                $query->where('agent_id', $agent->id);
            })->orderBy('date_admission', 'desc')->paginate(10);
        }

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }
}
