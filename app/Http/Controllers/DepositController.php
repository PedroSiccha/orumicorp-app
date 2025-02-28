<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Customers;
use App\Models\Deposit;
use App\Models\Premio;
use App\Models\Sales;
use App\Models\TransactionType;
use App\Models\User;
use App\Services\DepositService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class DepositController extends Controller
{

    protected $depositService;

    public function __construct(DepositService $depositService) {
        $this->depositService = $depositService;
    }

    public function index()
    {
        try {
            $data = $this->depositService->getDataDeposits();
            $agent = $data->agent;
            $rouletteSpin = $data->rouletteSpin;
            $transactionsType = $data->transactionsType;
            $deposits = $data->deposits;
            $sales = $data->sales;
        } catch (Exception $e) {
            Log::error("Error en DepositController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar los depósitos.');
        }
        // $user_id = Auth::user()->id;
        // $user = User::where('id', $user_id)->first();
        // $roles = $user->getRoleNames()->first();
        // $agent = Agent::where('user_id', $user_id)->first();
        // $dataUser = $agent;


        // $agent = Agent::where('user_id', $user_id)->first();
        // $premios1 = Premio::where('status', true)->where('type', 1)->get();
        // $premios2 = Premio::where('status', true)->where('type', 2)->get();
        // $rouletteSpin = $agent->number_turns ?: 0;
        // $transactionsType = TransactionType::all();
        // $deposits = Deposit::with('customer')->with(['agent', 'user'])->get();
        // foreach ($deposits as &$deposit) {
        //     if (isset($deposit['date'])) {
        //         $deposit['date'] = Carbon::parse($deposit['date'])->format('d/m/Y');
        //     }

        // }
        // $sales = Sales::where('status', 1)->whereHas('agent')->whereHas('customer')->with(['agent', 'customer'])->get();
        return view('deposit.index', compact('premios1', 'premios2','rouletteSpin', 'dataUser', 'deposits', 'transactionsType', 'sales'));
    }

    public function saveDeposit(DepositRequest $request)
    {
        try {
            $data = $this->depositService->saveDeposit($request);
            $deposits = $data->deposits;
            return response()->json(["view"=>view('deposit.table.tableDeposit', compact('deposits'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en DepositController: " . $e->getMessage());
        }
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";

        // $client = Customers::where('code', $request->codeClient)->first();

        // $agent = Agent::where('code_voiso', $request->codeAgent)
        //               ->orWhere('code', $request->codeAgent)
        //               ->first();

        // $user_id = Auth::user()->id;

        // try {
        //     $deposit = new Deposit();
        //     $deposit->agent_id = $agent->id;
        //     $deposit->customer_id = $client->id;
        //     $deposit->date = Carbon::now();
        //     $deposit->number = $request->codeReceipt;
        //     $deposit->tipo = "DEPOSITO";
        //     $deposit->descripcion = "";
        //     $deposit->amount = $request->amount;
        //     $deposit->transaction_type_id = $request->transaction_type_id;
        //     $deposit->users_id = $user_id;

        //     if ($deposit->save()) {
        //         $title = "Correcto";
        //         $mensaje = "Su depósito se registró correctamente";
        //         $status = "success";
        //     }

        // } catch (ValidationException $e) {
        //     $title = "Error";
        //     $mensaje = $e->getMessage();
        //     $status = "error";
        // } catch (Exception $e) {
        //     $title = "Error";
        //     $mensaje = $e->getMessage();
        //     $status = "error";
        // }

        // $deposits = Deposit::with('customer')->with(['agent', 'user'])->get();
        // foreach ($deposits as &$deposit) {
        //     if (isset($deposit['date'])) {
        //         $deposit['date'] = Carbon::parse($deposit['date'])->format('d/m/Y');
        //     }

        // }

        // return response()->json(["view"=>view('deposit.table.tableDeposit', compact('deposits'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

}
