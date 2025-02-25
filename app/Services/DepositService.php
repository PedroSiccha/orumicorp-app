<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class DepositService
{
    public function getDataDeposits() {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        $roles = $user->getRoleNames()->first();
        $agent = $this->agentRepository->getAgentByUser(); // Agent::where('user_id', $user_id)->first();

        $rouletteSpin = $agent->number_turns ?: 0;
        $transactionsType = $this->transactionTypeService->getTransactionTypes(); // TransactionType::all();
        $deposits = $this->depositService->getDeposits(); // Deposit::with('customer')->with(['agent', 'user'])->get();
        foreach ($deposits as &$deposit) {
            if (isset($deposit['date'])) {
                $deposit['date'] = Carbon::parse($deposit['date'])->format('d/m/Y');
            }

        }
        $sales = $this->salesRepository->getSales(); // Sales::where('status', 1)->whereHas('agent')->whereHas('customer')->with(['agent', 'customer'])->get();
    }

    public function saveDeposit($request)
    {
        
        $client = $this->clientService->getClientsByCode(); // Customers::where('code', $request->codeClient)->first();

        $agent = $this->clientService->getAgentByCode();
        // Agent::where('code_voiso', $request->codeAgent)
        //               ->orWhere('code', $request->codeAgent)
        //               ->first();

        $user_id = Auth::user()->id;

        DB::beginTransaction();
        try {
            $deposit = $this->depositRepository->saveDeposit($request);
            DB::commit();
            // $deposit = new Deposit();
            // $deposit->agent_id = $agent->id;
            // $deposit->customer_id = $client->id;
            // $deposit->date = Carbon::now();
            // $deposit->number = $request->codeReceipt;
            // $deposit->tipo = "DEPOSITO";
            // $deposit->descripcion = "";
            // $deposit->amount = $request->amount;
            // $deposit->transaction_type_id = $request->transaction_type_id;
            // $deposit->users_id = $user_id;

            // if ($deposit->save()) {
            //     $title = "Correcto";
            //     $mensaje = "Su depósito se registró correctamente";
            //     $status = "success";
            // }

        } catch (ValidationException $e) {
            DB::rollBack();
            // $title = "Error";
            // $mensaje = $e->getMessage();
            // $status = "error";
        } catch (Exception $e) {
            DB::rollBack();
            // $title = "Error";
            // $mensaje = $e->getMessage();
            // $status = "error";
        }

        $deposits = $this->depositService->getDeposits(); // Deposit::with('customer')->with(['agent', 'user'])->get();
        foreach ($deposits as &$deposit) {
            if (isset($deposit['date'])) {
                $deposit['date'] = Carbon::parse($deposit['date'])->format('d/m/Y');
            }

        }
    }
}