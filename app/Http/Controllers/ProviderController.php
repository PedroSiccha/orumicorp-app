<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProviderRequest;
use App\Models\Provider;
use App\Models\User;
use App\Services\ProviderService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class ProviderController extends Controller
{

    protected $providerService;

    public function __construct(ProviderService $providerService) {
        $this->providerService = $providerService;
    }

    public function saveProvider(ProviderRequest $request)
    {
        try {
            $data = $this->providerService->saveProvider($request);
            $suppliers = $data->suppliers;
            return response()->json(["view"=>view('provider.table.tableProvider', compact('suppliers'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en ProviderController: " . $e->getMessage());
        }
    }

    public function updateProvider(ProviderRequest $request)
    {
        try {
            $data = $this->providerService->updateProvider($request);
            $suppliers = $data->suppliers;
            return response()->json(["view"=>view('provider.table.tableProvider', compact('suppliers'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en ProviderController: " . $e->getMessage());
        }
    }

    public function deleteProvider(ProviderRequest $request)
    {
        try {
            $data = $this->providerService->deleteProvider($request);
            $suppliers = $data->suppliers;
            return response()->json(["view"=>view('provider.table.tableProvider', compact('suppliers'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en ProviderController: " . $e->getMessage());
        }
    }

}
