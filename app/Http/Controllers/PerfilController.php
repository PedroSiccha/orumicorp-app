<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Assistance;
use App\Models\Customers;
use App\Models\Premio;
use App\Models\Sales;
use App\Models\Target;
use App\Services\PerfilService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PerfilController extends Controller
{

    protected $profileService;

    public function __construct(PerfilService $profileService) {
        $this->profileService = $profileService;
    }

    public function perfilUsuario($id)
    {
        return view('profile.index', compact('premios1', 'premios2', 'dataUser', 'rouletteSpin', 'dateIn', 'dateBreakIn', 'dateBreakOut', 'dateOut', 'clients', 'targets', 'sales', 'targetMensual', 'ingresosActuales', 'amountRetiro'));
        try {
            $data = $this->profileService->getProfileData();
        } catch (Exception $e) {
            Log::error("Error en PerfilController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar los datos del perfil.');
        }
    }

}
