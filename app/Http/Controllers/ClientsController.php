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
            $customers = Customers::orderBy('date_admission')->get();
            $title = "Correcto";
            $mensaje = "El cliente se importó correctamente";
            $status = "success";

            return response()->json([
                "view" => view('cliente.list.listCustomer', compact('customers'))->render(),
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
}
