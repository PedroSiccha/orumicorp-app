<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Http\Controllers\Controller;
use App\Http\Requests\FolderRequest;
use App\Interfaces\RolesInterface;
use App\Models\Agent;
use App\Models\Campaing;
use App\Models\Customers;
use App\Models\CustomerStatus;
use App\Models\Provider;
use App\Services\FolderService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FolderController extends Controller
{

    protected $rolesService;
    protected $folderService;

    public function __construct(
        RolesInterface $rolesService,
        FolderService $folderService
    ) {
        $this->rolesService = $rolesService;
        $this->folderService = $folderService;
    }

    public function deleteFolder(FolderRequest $request)
    {
        try {
            $data = $this->folderService->deleteFolder($request);
            $folders = $data->folders;
            return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en FolderController: " . $e->getMessage());
        }
    }

    public function addGroupClientFolder(FolderRequest $request)
    {
        try {
            $data = $this->folderService->addGroupClientFolder($request);
            $folders = $data->folders;
            $customers = $data->customers;
            $agents = $data->agents;
            $campaings = $data->campaings;
            $providers = $data->providers;
            $statusCustomers = $data->statusCustomers;
            return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en FolderController: " . $e->getMessage());
        }
    }

    public function saveFolder(FolderRequest $request)
    {
        try {
            $data = $this->folderService->saveFolder($request);
            $folders = $data->folders;
            return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en FolderController: " . $e->getMessage());
        }
    }

    public function addClientFolder(FolderRequest $request)
    {
        try {
            $data = $this->folderService->addClientFolder($request);
            $clients = $data->clients;
            return response()->json(["view"=>view('shooter.components.listClient', compact('clients'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en FolderController: " . $e->getMessage());
        }
    }

    public function moveFolder(FolderRequest $request)
    {
        try {
            $data = $this->folderService->moveFolder($request);
            $folders = $data->folders;
            return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en FolderController: " . $e->getMessage());
        }
    }

    public function editFolder(FolderRequest $request)
    {
        try {
            $data = $this->folderService->editFolder($request);
            $folders = $data->folders;
            return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en FolderController: " . $e->getMessage());
        }
    }

    public function changeFolderClient(FolderRequest $request)
    {
        try {
            $data = $this->folderService->changeFolderClient($request);
            $customers = $data->customers;
            $agents = $data->agents;
            $campaings = $data->campaings;
            $providers = $data->providers;
            $statusCustomers = $data->statusCustomers;
            return response()->json(["view"=>view('shooter.components.listClient', compact('customers'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en FolderController: " . $e->getMessage());
        }
    }
}
