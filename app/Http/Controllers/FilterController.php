<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Models\Agent;
use App\Models\Campaing;
use App\Models\Customers;
use App\Models\CustomerStatus;
use App\Models\Provider;
use App\Services\ClientService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FilterController extends Controller
{

    protected $customerService;

    public function __construct(ClientService $customerService) {
        $this->customerService = $customerService;
    }

    public function filterAdvanced(FilterRequest $request)
    {
        $filterFor = $request->filterFor;
        $inputName = $request->inputName;
        $statusId = $request->statusId;
        $typeRange = $request->typeRange;
        $dateInit = $request->dateInit;
        $dateEnd = $request->dateEnd;

        try {
            $data = $this->customerService->filterAdvanced($request);
            $customers = $data->customers;
            $agents = $data->agents;
            $campaings = $data->campaings;
            $providers = $data->providers;
            $statusCustomers = $data->statusCustomers;
            return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render()]);

        } catch (Exception $e) {
            Log::error("Error en FilterController: " . $e->getMessage());
        }
        
    }

}
