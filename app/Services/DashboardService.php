<?php
namespace App\Services;
class DashboardService
{
    public function getDashboard() {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        $roles = $user->getRoleNames()->first();

        $agent = $this->agentRepository->getAgentByUser(); // Agent::where('user_id', $user_id)->first();
        $rouletteSpin = $agent->number_turns ?: 0;

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $previousMonth = Carbon::now()->subMonth()->month;
        $previousYear = Carbon::now()->subMonth()->year;

        $sales = null;
        $totalAmount = 0;

        $sales = $this->salesRepository->getSalesNowByAgent();
        // if ($roles == 'ADMINISTRADOR') {
        //     $sales = Sales::where('status', true)
        //                 ->where('action_id', 1)
        //                 ->where(function ($query) use ($currentMonth, $currentYear, $previousMonth, $previousYear) {
        //                     $query->whereYear('date_admission', $currentYear)->whereMonth('date_admission', $currentMonth)
        //                             ->orWhere(function ($query) use ($previousMonth, $previousYear) {
        //                                 $query->whereYear('date_admission', $previousYear)->whereMonth('date_admission', $previousMonth);
        //                             });
        //                 })
        //                 ->orderBy('date_admission', 'desc')
        //                 ->get();
        // } else {
        //     if ($agent) {
        //         $sales = Sales::where('status', true)
        //                 ->where('action_id', 1)
        //                 ->where('agent_id', $agent->id)
        //                 ->where(function ($query) use ($currentMonth, $currentYear, $previousMonth, $previousYear) {
        //                     $query->whereYear('date_admission', $currentYear)->whereMonth('date_admission', $currentMonth)
        //                             ->orWhere(function ($query) use ($previousMonth, $previousYear) {
        //                                 $query->whereYear('date_admission', $previousYear)->whereMonth('date_admission', $previousMonth);
        //                             });
        //                 })
        //                 ->orderBy('date_admission', 'desc')
        //                 ->get();
        //     }
        // }

        $totalAmount = $sales->sum('amount');

        $agents = $this->agentRepository->getAgents(); //Agent::get();
        $clients = $this->agentRepository->getClients(); // Customers::get();
        $cantAgents = count($agents);
        $cantClients = count($clients);

        $montoVenta = $this->salesRepository->getAmountSales();
        //  Sales::join('agents', 'sales.agent_id', '=', 'agents.id')
        //                     ->where('agents.area_id', 1)
        //                     ->sum('sales.amount');

        $montoRetencion = $this->salesRepository->getAmountRetention();
        //  Sales::join('agents', 'sales.agent_id', '=', 'agents.id')
        //                         ->where('agents.area_id', 2)
        //                         ->sum('sales.amount');

        $montosPorAgente = $this->salesRepository->getAmountSalesByAgent();
        //  Sales::selectRaw('SUM(sales.amount) AS monto, agents.name, agents.lastname, areas.name AS area')
        //                         ->join('agents', 'sales.agent_id', '=', 'agents.id')
        //                         ->join('areas', 'agents.area_id', '=', 'areas.id')
        //                         ->groupBy('agents.id')
        //                         ->orderBy('monto', 'desc')
        //                         ->take(10)
        //                         ->get();

        $cantClientsRegisterProvider = 0;
        $percentClientsRegisterProvider = 0;
        $cantClientsActiveProvider = 0;
        $percentClientsActiveProvider = 0;
        $cantClientsProvider = 0;
        $listClientsProvider = [];

        if ($roles == 'PROVEEDOR') {
            $providerId = $this->providerService->getProviderByUser(); // Provider::where('user_id', $user_id)->first()->id;
            $cantClientsRegisterProvider = $this->clientService->getCantClientsRegisterByProvider(); // Customers::where('id_provider', $providerId)->whereMonth('date_admission', Carbon::now()->month)->whereYear('date_admission', Carbon::now()->year)->count();
            $cantClientsActiveProvider = $this->clientService->getCantClientsActiveByProvider(); // para ver FDT tiebe que estar en activo
            // Customers::where('id_provider', $providerId)->whereHas('deposits', function($query) {
            //                                             $query->whereMonth('date', Carbon::now()->month)
            //                                                 ->whereYear('date', Carbon::now()->year);
            //                                         })->distinct('id')->count();
            $cantClientsProvider = $this->clientService->getCantClientsByProvider();
            // Customers::where('id_provider', $providerId)->whereYear('date_admission', Carbon::now()->year)->count();
            if ($cantClientsRegisterProvider > 0) {
                $percentClientsActiveProvider = round(($cantClientsActiveProvider / $cantClientsRegisterProvider) * 100, 2);
            }
            if ($cantClientsProvider > 0) {
                $percentClientsRegisterProvider = round(($cantClientsRegisterProvider / $cantClientsProvider) * 100, 2);
            }
            $listClientsProvider = $this->clientService->getListClientsProvider();
            // Customers::where('id_provider', $providerId)->whereMonth('date_admission', Carbon::now()->month)->whereYear('date_admission', Carbon::now()->year)->with('statusCustomer')->get();
        }
    }
}