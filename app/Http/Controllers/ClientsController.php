<?php

namespace App\Http\Controllers;

use App\Imports\CustomersImport;
use App\Imports\UsersImport;
use App\Interfaces\ClientInterface;
use App\Interfaces\UserInterface;
use App\Models\Agent;
use App\Models\Customers;
use App\Models\Premio;
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
    protected $clientService, $userService;

    public function __construct(
        ClientInterface $clientService
    ) {
        $this->clientService = $clientService;
    }

    public function index()
    {
        $data = $this->clientService->index();
        return view('cliente.index', $data);
    }

    public function saveCustomer(Request $request)
    {
        $data = $this->clientService->saveClient($request);
        $customers = Customers::orderBy('date_admission')->get();
        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "title"=>$data['title'], "text"=>$data['mensaje'], "status"=>$data['status']]);
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
        $customers = Customers::orderBy('date_admission')->get();
        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "title"=>$data['title'], "text"=>$data['mensaje'], "status"=>$data['status']]);
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

        return Response::download($archivo, 'CARGA_MASIVA_DE_CLNT.xlsx');
    }

    public function uploadExcel(Request $request)
    {
        $file = $request->file;

        Excel::import(new CustomersImport, $file, null, \Maatwebsite\Excel\Excel::XLSX, [
            AfterImport::class => function (AfterImport $event) {
                $customers = Customers::orderBy('date_admission')->paginate(10);
                $title = "Correcto";
                $mensaje = "El cliente se eliminó correctamente";
                $status = "success";

                return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
            }
        ]);
    }

    public function profileClient($id) {
        $data = $this->clientService->profileClient($id);
        return view('cliente.profile', $data);
    }
}
