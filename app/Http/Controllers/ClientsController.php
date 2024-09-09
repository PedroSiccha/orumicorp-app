<?php

namespace App\Http\Controllers;

use App\Imports\CustomersImport;
use App\Imports\UsersImport;
use App\Interfaces\ClientInterface;
use App\Interfaces\RolesInterface;
use App\Interfaces\UserInterface;
use App\Models\Agent;
use App\Models\Campaing;
use App\Models\Configuration;
use App\Models\Customers;
use App\Models\CustomerStatus;
use App\Models\Premio;
use App\Models\Provider;
use App\Models\User;
use App\Rules\PhoneNumberFormat;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Webpatser\Countries\Countries;

class ClientsController extends Controller
{
    protected $clientService, $userService, $rolesService;

    public function __construct(
        ClientInterface $clientService,
        RolesInterface $rolesService,
    ) {
        $this->clientService = $clientService;
        $this->rolesService = $rolesService;
    }

    public function index()
    {
        $data = $this->clientService->index();
        return view('cliente.index', $data);
    }

    public function clientsPagination(Request $request)
    {
        $myRoles = $this->rolesService->getMyRoles();
        $myRolesId = $myRoles['rolesId'];

        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();

        $limit = $request->input('limit', 10); // Por defecto muestra 10 registros

        if ($myRoles['roles'] == 'ADMINISTRADOR') {
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
            ])->orderBy('date_admission', 'desc')->paginate($limit);
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
                'latestComunication',
                'latestAssignamet',
                'latestDeposit'
            ])->where('agent_id', $agent->id)->orderBy('date_admission', 'desc')->paginate($limit);
        }

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'));
    }


    public function saveCustomer(Request $request)
    {
        $myRoles = $this->rolesService->getMyRoles();
        $myRolesId = $myRoles['rolesId'];

        $data = $this->clientService->saveClient($request);
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
                'latestComunication',
                'latestAssignamet',
                'latestDeposit'
            ])->where('agent_id', $agent->id)->orderBy('date_admission', 'desc')->paginate(10);
        }

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(), "title"=>$data['title'], "text"=>$data['mensaje'], "status"=>$data['status']]);
    }

    public function asignAgent(Request $request)
    {
        $data = $this->clientService->asignAgent($request);
        $customers = Customers::orderBy('date_admission')->get();
        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "title"=>$data['title'], "text"=>$data['mensaje'], "status"=>$data['status']]);

    }

    public function assignGroupAgent(Request $request)
    {
        $data = $this->clientService->assignGroupAgent($request);

        $myRoles = $this->rolesService->getMyRoles();
        $myRolesId = $myRoles['rolesId'];

        // $data = $this->clientService->saveClient($request);
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
                'latestComunication',
                'latestAssignamet',
                'latestDeposit'
            ])->where('agent_id', $agent->id)->orderBy('date_admission', 'desc')->paginate(10);
        }

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(), "title"=>$data['title'], "text"=>$data['mensaje'], "status"=>$data['status']]);
    }

    public function changeStatusGroup(Request $request)
    {
        $title = 'Error';
        $mensaje = 'Error desconocido';
        $status = 'error';

        // dd($request);

        $myRoles = $this->rolesService->getMyRoles();
        $myRolesId = $myRoles['rolesId'];
        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();

        try {
            foreach ($request->idGroupClientes as $idClient) {

                $client = Customers::find($idClient);
                $client->id_status = $request->statusId;
                $client->save();

            }

            $title = "Correcto";
            $mensaje = "Actualización correcta";
            $status = "success";

        } catch (Exception $e) {
            $title = "Error";
            $mensaje = "Ocurrió un error: " . $e->getMessage();
            $status = "error";
        }

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
                'latestComunication',
                'latestAssignamet',
                'latestDeposit'
            ])->where('agent_id', $agent->id)->orderBy('date_admission', 'desc')->paginate(10);
        }

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function searchStatus(Request $request) {
        $customerStatusId = $request->customerStatusId;

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
            ])->where('id_status', $customerStatusId)->orderBy('date_admission', 'desc')->paginate(50);

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
                'latestComunication',
                'latestAssignamet',
                'latestDeposit'
            ])->where('agent_id', $agent->id)->where('id_status', $customerStatusId)->orderBy('date_admission', 'desc')->paginate(50);
        }

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render()]);

    }

    public function changeStatusClient(Request $request)
    {
        $data = $this->clientService->changeStatusClient($request);
        $customers = Customers::orderBy('date_admission')->get();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "title"=>$data['title'], "text"=>$data['mensaje'], "status"=>$data['status']]);

    }

    public function updateClient(Request $request)
    {
        $data = $this->clientService->updateClient($request);

        $customers = Customers::orderBy('date_admission')->get();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "title"=>$data['title'], "text"=>$data['mensaje'], "status"=>$data['status']]);
    }

    public function deleteClient(Request $request)
    {
        $data = $this->clientService->deleteClient($request);

        $customers = Customers::orderBy('date_admission')->get();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "title"=>$data['title'], "text"=>$data['mensaje'], "status"=>$data['status']]);

    }

    public function descargarArchivo()
    {
        $archivo = public_path('utils/CARGA_MASIVA_DE_CLNT.xlsx');

        // return Response::download($archivo, 'CARGA_MASIVA_DE_CLNT.xlsx');

        return response()->download($archivo, 'CARGA_MASIVA_DE_CLNT.xlsx', [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function uploadExcel(Request $request)
    {
        //dd($request);
        // Verificar que se ha enviado un archivo
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        $file = $request->file('file');

        // Verificar que el archivo es válido
        if (!$file->isValid()) {
            return response()->json(['error' => 'Invalid file upload'], 400);
        }

        try {
            Excel::import(new CustomersImport, $file);

            // Lógica post-importación
            // $customers = Customers::orderBy('date_admission')->get();

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
                ])->orderBy('date_admission', 'desc')->paginate(50);

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
                    'latestComunication',
                    'latestAssignamet',
                    'latestDeposit'
                ])->where('agent_id', $agent->id)->orderBy('date_admission', 'desc')->paginate(50);
            }

            $agents = Agent::all();
            $campaings = Campaing::all();
            $providers = Provider::all();
            $statusCustomers = CustomerStatus::all();

            $title = "Correcto";
            $mensaje = "El cliente se importó correctamente";
            $status = "success";

            return response()->json([
                "view" => view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(),
                "title" => $title,
                "text" => $mensaje,
                "status" => $status
            ], 200);
        } catch (Exception $e) {
            // Manejo de errores
            //dd($e->getMessage());
            return response()->json(['error' => 'Failed to upload file', 'message' => $e->getMessage()], 500);
        }
    }

    public function profileClient($id) {
        $data = $this->clientService->profileClient($id);
        return view('cliente.profile', $data);
    }

    public function saveConfigTable(Request $request) {

        $estadoDateInit = "active";
        $estadoCode = "active";
        $estadoPhone = "active";
        $estadoOptionalPhone = "active";
        $estadoEmail = "active";
        $estadoCity = "active";
        $estadoCountry = "active";
        $estadoComment = "active";

        if ($request->configTablesDateInit != "true") {
            $estadoDateInit = 'inactive';
        }


        try {

            $user = Auth::user();
            $user_id = $user->id;

            $configTablesDateInit = Configuration::where('user_id', $user_id)
                                        ->where('view', 'tabClient')
                                        ->where('name', 'date_init')
                                        ->first();

            $configTablesDateInit->status = $estadoDateInit;
            if ($configTablesDateInit->save()) {

                $configTablesCode = Configuration::where('user_id', $user_id)
                                        ->where('view', 'tabClient')
                                        ->where('name', 'code')
                                        ->first();

                $configTablesCode->status = $request->configTablesCode == "true" ? 'active': 'inactive';
                if ($configTablesCode->save()) {
                    $configTablesPhone = Configuration::where('user_id', $user_id)
                                        ->where('view', 'tabClient')
                                        ->where('name', 'phone')
                                        ->first();

                    $configTablesPhone->status = $request->configTablesPhone == "true" ? 'active': 'inactive';
                    if ($configTablesPhone->save()) {
                        $configTablesOptionalPhone = Configuration::where('user_id', $user_id)
                                        ->where('view', 'tabClient')
                                        ->where('name', 'optional_phone')
                                        ->first();

                        $configTablesOptionalPhone->status = $request->configTablesOptionalPhone == "true" ? 'active': 'inactive';
                        if ($configTablesOptionalPhone->save()) {
                            $configTablesEmail = Configuration::where('user_id', $user_id)
                                        ->where('view', 'tabClient')
                                        ->where('name', 'email')
                                        ->first();

                            $configTablesEmail->status = $request->configTablesEmail == "true" ? 'active': 'inactive';
                            if ($configTablesEmail->save()) {
                                $configTablesCity = Configuration::where('user_id', $user_id)
                                        ->where('view', 'tabClient')
                                        ->where('name', 'city')
                                        ->first();

                                $configTablesCity->status = $request->configTablesCity == "true" ? 'active': 'inactive';

                                if ($configTablesCity->save()) {
                                    $configTablesCountry = Configuration::where('user_id', $user_id)
                                        ->where('view', 'tabClient')
                                        ->where('name', 'country')
                                        ->first();

                                    $configTablesCountry->status = $request->configTablesCountry == "true" ? 'active': 'inactive';
                                    if ($configTablesCountry->save()) {
                                        $configTablesComment = Configuration::where('user_id', $user_id)
                                        ->where('view', 'tabClient')
                                        ->where('name', 'comment')
                                        ->first();

                                        $configTablesComment->status = $request->configTablesComment == "true" ? 'active': 'inactive';
                                        if ($configTablesComment->save()) {

                                        }

                                    }

                                }

                            }

                        }

                    }

                }


            }

            $title = "Correcto";
            $mensaje = "Tabla personalizada";
            $status = "success";
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = "Ocurrió un error: " . $e->getMessage();
            $status = "error";
        }

        $customers = Customers::orderBy('date_admission')->get();

        $configTablesDateInit = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'date_init')
                                     ->first();

        $configTablesCode = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'code')
                                     ->first();

        $configTablesPhone = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'phone')
                                     ->first();

        $configTablesOptionalPhone = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'optional_phone')
                                     ->first();

        $configTablesEmail = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'email')
                                     ->first();

        $configTablesCity = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'city')
                                     ->first();

        $configTablesCountry = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'country')
                                     ->first();

        $configTablesComment = Configuration::where('user_id', $user_id)
                                     ->where('view', 'tabClient')
                                     ->where('name', 'comment')
                                     ->first();

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'configTablesDateInit', 'configTablesCode', 'configTablesPhone', 'configTablesOptionalPhone', 'configTablesEmail', 'configTablesCity', 'configTablesCountry', 'configTablesComment', 'agents', 'campaings', 'providers', 'statusCustomers'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function filterOrder(Request $request) {

        $order = $request->order;
        $type = $request->type;

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
            ])->orderBy($order, $type)->paginate(50);

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
                'latestComunication',
                'latestAssignamet',
                'latestDeposit'
            ])->where('agent_id', $agent->id)->orderBy($order, $type)->paginate(50);
        }

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render()]);
    }

    public function filterByAttr(Request $request) {
        $id = $request->id;
        $type = $request->type;

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
            ])->where($type, $id)->paginate(50);

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
                'latestComunication',
                'latestAssignamet',
                'latestDeposit'
            ])->where('agent_id', $agent->id)->where($type, $id)->paginate(50);
        }

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        dd($customers);

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render()]);
    }

    public function filterByDate(Request $request) {
        $order = $request->order;
        $type = $request->type;

        $formattedDate = Carbon::now()->format('Y-m-d');

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
            ])->whereBetween($order, [$formattedDate, $formattedDate])->paginate(50);

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
                'latestComunication',
                'latestAssignamet',
                'latestDeposit'
            ])->where('agent_id', $agent->id)->whereBetween($order, [$formattedDate, $formattedDate])->paginate(50);
        }

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render()]);
    }
}
