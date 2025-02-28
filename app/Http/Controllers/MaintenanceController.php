<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Campaing;
use App\Models\CustomerStatus;
use App\Models\Platform;
use App\Models\Premio;
use App\Models\Provider;
use App\Models\Traiding;
use App\Models\TransactionType;
use App\Models\User;
use App\Services\MaintenanceService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MaintenanceController extends Controller
{

    protected $maintenanceService;

    public function __construct(MaintenanceService $maintenanceService) {
        $this->maintenanceService = $maintenanceService;
    }

    public function index()
    {
        try {
            $data = $this->maintenanceService->getMaintenanceData();
            $rouletteSpin = $data->rouletteSpin;
            $customersStatus = $data->customersStatus;
            $campaigns = $data->campaigns;
            $suppliers = $data->suppliers;
            $platforms = $data->platforms;
            $traidings = $data->traidings;
            $transactionsType = $data->transactionsType;
            return view('maintenance.index', compact('rouletteSpin', 'customersStatus', 'campaigns', 'suppliers', 'platforms', 'traidings', 'transactionsType'));
        } catch (Exception $e) {
            Log::error("Error en MaintenanceController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar los datos de mantenimiento.');
        }
    }

}
