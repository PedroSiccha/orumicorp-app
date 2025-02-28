<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrizeRequest;
use App\Http\Requests\SaleRequest;
use App\Models\Agent;
use App\Models\Customers;
use App\Models\Premio;
use App\Models\Sales;
use App\Services\AgentService;
use App\Services\DepositService;
use App\Services\GestionRuletaService;
use App\Services\SalesService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GestionRuletaController extends Controller
{
    protected $depositService;
    protected $gestionRuletaService;
    protected $agentService;
    protected $saleService;

    public function __construct(
        DepositService $depositService,
        GestionRuletaService $gestionRuletaService,
        AgentService $agentService,
        SalesService $saleService
    ) {
        $this->depositService = $depositService;
        $this->gestionRuletaService = $gestionRuletaService;
        $this->agentService = $agentService;
        $this->saleService = $saleService;
    }

    public function index()
    {
        try {
            $data = $this->depositService->getDepositData();
            $premios = $data->premios;
            $rouletteSpin = $data->rouletteSpin;
            return view('gestionRuleta.index', compact('premios'));
        } catch (Exception $e) {
            Log::error("Error en DepositController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar los depósitos.');
        }
    }

    // Obtener premios activos
    public function indexTest()
    {
        return response()->json(Premio::where('active', true)->get());
    }

    // Guardar el premio obtenido
    public function storeWinner(WinnerRequest $request)
    {
        try {
            $data = $this->depositService->saveDeposit($request);
        } catch (Exception $e) {
            Log::error("Error en DepositController: " . $e->getMessage());
        }
        // $request->validate([
        //     'prize_id' => 'required|exists:premios,id'
        // ]);

        // $user_id = Auth::user()->id;
        // $agent = Agent::where('user_id', $user_id)->first();
        // $premio = Premio::where('id', $request->prize_id)->first();

        // $sale = new Sales();
        // $sale->date_admission = Carbon::now();
        // $sale->status = true;
        // $sale->observation = "Giro de Ruleta";
        // $sale->commission = $premio->value;
        // $sale->agent_id = $agent->id;
        // $sale->action_id = '2';
        // $sale->user_id = $user_id;
        // if ($sale->save()) {
        //     $cant_giro = $agent->number_turns;
        //     $new_giro = 0;
        //     if ($cant_giro > 0) {
        //         $new_giro = $cant_giro - 1;
        //     }
        //     $agent->number_turns = $new_giro;
        //     $agent->save();
        // }

        // // Aquí podrías guardar el premio en un historial
        // return response()->json(['message' => 'Premio registrado con éxito']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function savePremio(PrizeRequest $request)
    {
        try {
            $data = $this->gestionRuletaService->savePrize($request);
            $premios = $data->premios;
            return response()->json(["view"=>view('gestionRuleta.components.tabPremio', compact('premios'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en DepositController: " . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateGiro(TurnRequest $request)
    {
        try {
            $data = $this->agentService->saveTurn($request);
        } catch (Exception $e) {
            Log::error("Error en DepositController: " . $e->getMessage());
        }
    }

    public function getPremio(SaleRequest $request)
    {
        try {
            $data = $this->saleService->saveSale($request);
        } catch (Exception $e) {
            Log::error("Error en DepositController: " . $e->getMessage());
        }
    }

}
